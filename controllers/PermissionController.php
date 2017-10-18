<?php

namespace yeesoft\user\controllers;

use Yii;
use yii\base\Model;
use yii\base\DynamicModel;
use yeesoft\models\AuthItem;
use yeesoft\models\AuthPermission;
use yeesoft\helpers\AuthHelper;
use yeesoft\controllers\CrudController;
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

        $routes = $model->getRoutes()->select('id')->column();
        $childPermissions = AuthHelper::getChildrenByType($model->name, AuthItem::TYPE_PERMISSION);
        $permissions = array_keys($childPermissions);

        $dynamicModel = new DynamicModel(['childPermissions', 'permissionRoutes']);
        $dynamicModel->addRule(['childPermissions', 'permissionRoutes'], 'safe');
        $dynamicModel->permissionRoutes = $routes;
        $dynamicModel->childPermissions = $permissions;

        if ($model->load(Yii::$app->request->post()) AND $model->save()) {
            $dynamicModel->load(Yii::$app->request->post());
            $dynamicModel->permissionRoutes = is_array($dynamicModel->permissionRoutes) ? $dynamicModel->permissionRoutes : [];
            $dynamicModel->childPermissions = is_array($dynamicModel->childPermissions) ? $dynamicModel->childPermissions : [];

            //Routes
            $routesToAdd = array_diff($dynamicModel->permissionRoutes, $routes);
            $routesToRemove = array_diff($routes, $dynamicModel->permissionRoutes);

            $authManager->addRoutesToPermission($model->name, $routesToAdd);
            $authManager->removeRoutesFromPermission($model->name, $routesToRemove);

            //Child Permissions
            $permission = $authManager->getPermission($model->name);
            $permissionsToAdd = array_diff($dynamicModel->childPermissions, $permissions);
            $permissionsToRemove = array_diff($permissions, $dynamicModel->childPermissions);

            foreach ($permissionsToAdd as $permissionName) {
                $authManager->addChild($permission, $authManager->getPermission($permissionName));
            }

            foreach ($permissionsToRemove as $permissionName) {
                $authManager->removeChild($permission, $authManager->getPermission($permissionName));
            }

            Yii::$app->session->setFlash('success', Yii::t('yee', 'Your item has been updated.'));
            return $this->redirect($this->getRedirectPage('update', $model));
        }

        return $this->renderIsAjax($this->updateView, compact('model', 'dynamicModel'));
    }

    protected function flushCache($event)
    {
        if (in_array($event->action->id, ['set-permissions', 'set-routes'])) {
            Yii::$app->authManager->flushRouteCache();
        }
    }

}
