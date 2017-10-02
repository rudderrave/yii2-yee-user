<?php

namespace yeesoft\user\controllers;

use Yii;
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
    public $disabledActions = ['view'];

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

    /**
     * @param int $id User ID
     *
     * @throws \yii\web\NotFoundHttpException
     * @return string
     */
    public function actionPermissions($id)
    {
        if (!$user = User::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('yee/user', 'User not found'));
        }

        $permissionsByGroup = [];
        $permissions = AuthPermission::find()
                ->andWhere([Yii::$app->authManager->itemTable . '.name' => array_keys(AuthPermission::getUserPermissions($user->id))])
                ->joinWith('group')
                ->all();

        foreach ($permissions as $permission) {
            $permissionsByGroup[@$permission->group->name][] = $permission;
        }

        return $this->renderIsAjax('permissions', compact('user', 'permissionsByGroup'));
    }

    /**
     * @param int $id - User ID
     *
     * @return \yii\web\Response
     */
    public function actionRoles($id)
    {
        if (!Yii::$app->user->isSuperadmin AND Yii::$app->user->id == $id) {
            Yii::$app->session->setFlash('error', Yii::t('yee/user', 'You can not change own permissions'));
            return $this->redirect(['set', 'id' => $id]);
        }

        $oldAssignments = array_keys(AuthRole::getUserRoles($id));

        // To be sure that user didn't attempt to assign himself some unavailable roles
        $newAssignments = array_intersect(AuthRole::getAvailableRoles(Yii::$app->user->isSuperAdmin, true), Yii::$app->request->post('roles', []));

        $toAssign = array_diff($newAssignments, $oldAssignments);
        $toRevoke = array_diff($oldAssignments, $newAssignments);

        foreach ($toRevoke as $role) {
            User::revokeRole($id, $role);
        }

        foreach ($toAssign as $role) {
            User::assignRole($id, $role);
        }

        Yii::$app->session->setFlash('success', Yii::t('yee', 'Saved'));

        return $this->redirect(['permissions', 'id' => $id]);
    }

}
