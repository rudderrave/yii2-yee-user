<?php

namespace yeesoft\user\controllers;

use Yii;
use yii\base\DynamicModel;
use yii\web\NotFoundHttpException;
use yeesoft\models\User;
use yeesoft\models\AuthRole;
use yeesoft\models\AuthPermission;
use yeesoft\controllers\CrudController;

/**
 * DefaultController implements the CRUD actions for User model.
 */
class DefaultController extends CrudController
{

    /**
     * @var User
     */
    public $modelClass = 'yeesoft\models\User';

    /**
     * @var UserSearch
     */
    public $modelSearchClass = 'yeesoft\user\models\UserSearch';

    /**
     * @inheritdoc
     */
    public $disabledActions = ['view'];

    /**
     * @inheritdoc
     */
    protected function getRedirectPage($action, $model = null)
    {
        switch ($action) {
            case 'delete':
                return ['index'];
                break;
            case 'update':
                return ['update', 'id' => $model->id];
                break;
            case 'create':
                return ['update', 'id' => $model->id];
                break;
            default:
                return ['index'];
        }
    }

    /**
     * @return mixed|string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User(['scenario' => 'newUser']);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->renderIsAjax('create', compact('model'));
    }

    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        /* @var $model \yeesoft\db\ActiveRecord */
        $model = $this->findModel($id);
        $model->scenario = $this->getActionScenario($this->action->id);

        /* @var $authManager \yeesoft\rbac\DbManager */
        $authManager = Yii::$app->authManager;
        $roles = array_keys($authManager->getRolesByUser($id));

        $dynamicModel = new DynamicModel(['roles']);
        $dynamicModel->addRule(['roles'], 'safe');
        $dynamicModel->roles = $roles;

        $groupedPermissions = [];
        $permissionKeys = array_keys($authManager->getPermissionsByUser($id));
        $permissions = AuthPermission::find()
                ->andWhere([$authManager->itemTable . '.name' => $permissionKeys])
                ->joinWith('groups')
                ->all();

        foreach ($permissions as $permission) {
            $groupedPermissions[@$permission->group->title][] = $permission;
        }

        if ($model->load(Yii::$app->request->post()) AND $model->save()) {


            if (Yii::$app->user->can('update-user-roles')) {
                $dynamicModel->load(Yii::$app->request->post());
                $dynamicModel->roles = is_array($dynamicModel->roles) ? $dynamicModel->roles : [];

                $rolesToAdd = array_diff($dynamicModel->roles, $roles);
                $rolesToRemove = array_diff($roles, $dynamicModel->roles);

                foreach ($rolesToAdd as $role) {
                    $authManager->assign((object) ['name' => $role], $model->id);
                }

                foreach ($rolesToRemove as $role) {
                    $authManager->revoke((object) ['name' => $role], $model->id);
                }
            }

            Yii::$app->session->setFlash('success', Yii::t('yee', 'Your item has been updated.'));
            return $this->redirect($this->getRedirectPage('update', $model));
        }

        return $this->renderIsAjax($this->updateView, compact('model', 'dynamicModel', 'groupedPermissions', 'roles'));
    }

    /**
     * @param int $id User ID
     *
     * @throws \yii\web\NotFoundHttpException
     * @return string
     */
    public function actionChangePassword($id)
    {
        $model = User::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException(Yii::t('yee/user', 'User not found'));
        }

        $model->scenario = 'changePassword';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('yee/auth', 'Password has been updated'));
            return $this->redirect(['change-password', 'id' => $model->id]);
        }

        return $this->renderIsAjax('changePassword', compact('model'));
    }

}
