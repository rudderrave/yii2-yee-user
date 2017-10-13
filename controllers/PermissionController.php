<?php

namespace yeesoft\user\controllers;

use Yii;
use yii\base\Model;
use yeesoft\controllers\CrudController;
use yeesoft\helpers\AuthHelper;
use yeesoft\models\AuthItem;
use yeesoft\models\AuthPermission;
use yeesoft\models\AuthRoute;
use yeesoft\user\models\AuthPermissionSearch;

class PermissionController extends CrudController
{

    /**
     * @var AuthPermission
     */
    public $modelClass = 'yeesoft\models\AuthPermission';

    /**
     * @var AuthPermissionSearch
     */
    public $modelSearchClass = 'yeesoft\user\models\AuthPermissionSearch';

    /**
     * @inheritdoc
     */
    public $disabledActions = ['view', 'toggle-attribute', 'bulk-activate', 'bulk-deactivate'];

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_AFTER_ACTION, [$this, 'flushCache']);
    }

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
                return ['update', 'id' => $model->{$this->modelPrimaryKey}];
                break;
            case 'create':
                return ['update', 'id' => $model->{$this->modelPrimaryKey}];
                break;
            default:
                return ['index'];
        }
    }

    /**
     * @inheritdoc
     */
    protected function getActionScenario($action = null)
    {
        $action = ($action) ?: $this->action->id;

        switch ($action) {
            case 'update':
                return 'update';
                break;
            default:
                return Model::SCENARIO_DEFAULT;
        }
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

        $routes = $this->getRoutes();
        $permissions = $this->getPermissions($id);

        $selectedRoutes = $model->getRoutes()->select('id')->column();
        $selectedPermissions = AuthHelper::getChildrenByType($model->name, AuthItem::TYPE_PERMISSION);

        $dynamicModel = new \yii\base\DynamicModel(['childPermissions', 'permissionRoutes']);
        $dynamicModel->addRule(['childPermissions', 'permissionRoutes'], 'safe');
        $dynamicModel->permissionRoutes = $selectedRoutes;
        $dynamicModel->childPermissions = array_keys($selectedPermissions);

        if ($model->load(Yii::$app->request->post()) AND $model->save()) {
            $dynamicModel->load(Yii::$app->request->post());

            //Set Routes
            $newRoutes = is_array($dynamicModel->permissionRoutes) ? $dynamicModel->permissionRoutes : [];

            $addRoutes = array_diff($newRoutes, $selectedRoutes);
            $removeRoutes = array_diff($selectedRoutes, $newRoutes);

            $authManager->addRoutesToPermission($model->name, $addRoutes);
            $authManager->removeRoutesFromPermission($model->name, $removeRoutes);


            //TODO: hidden checkbox input clear data from form
            
            //Set Child Permissions
            $oldPermissions = array_keys($selectedPermissions);
            $newPermissions = is_array($dynamicModel->childPermissions) ? $dynamicModel->childPermissions : [];

            $toRemove = array_diff($oldPermissions, $newPermissions);
            $toAdd = array_diff($newPermissions, $oldPermissions);

            $permission = $authManager->getPermission($model->name);

            foreach ($toAdd as $name) {
                $authManager->addChild($permission, $authManager->getPermission($name));
            }

            foreach ($toRemove as $name) {
                $authManager->removeChild($permission, $authManager->getPermission($name));
            }

            Yii::$app->session->setFlash('success', Yii::t('yee', 'Your item has been updated.'));
            return $this->redirect($this->getRedirectPage('update', $model));
        }

        return $this->renderIsAjax($this->updateView, compact('model', 'routes', 'permissions', 'selectedRoutes', 'selectedPermissions', 'dynamicModel'));
    }

    protected function flushCache($event)
    {
        if (in_array($event->action->id, ['set-permissions', 'set-routes'])) {
            Yii::$app->authManager->flushRouteCache();
        }
    }

    protected function getRoutes()
    {
        $result = [];
        $routes = AuthRoute::find()
                ->orderBy(['bundle' => SORT_ASC, 'controller' => SORT_ASC, 'action' => SORT_ASC])
                ->all();

        foreach ($routes as $route) {
            $result[$route->id] = $route->name;
        }

        return $result;
    }

    protected function getPermissions($currentPermissionid)
    {
        $result = [];
        $permissions = AuthPermission::find()
                ->andWhere(['not in', Yii::$app->authManager->itemTable . '.name', [$currentPermissionid]])
                ->joinWith('groups')
                ->all();

        foreach ($permissions as $permission) {
            $result[@$permission->group->title][] = $permission;
        }

        return $result;
    }

}
