<?php

namespace yeesoft\user\controllers;

use Yii;
use yii\rbac\Role;
use yii\rbac\Permission;
use yii\base\Model;
use yii\base\DynamicModel;
use yeesoft\models\AuthRole;
use yeesoft\user\models\AuthRoleSearch;
use yeesoft\controllers\CrudController;

class RoleController extends CrudController
{

    /**
     * @var AuthRole
     */
    public $modelClass = 'yeesoft\models\AuthRole';

    /**
     * @var AuthRoleSearch
     */
    public $modelSearchClass = 'yeesoft\user\models\AuthRoleSearch';

    /**
     * @inheritdoc
     */
    public $disabledActions = ['view', 'toggle-attribute', 'bulk-activate', 'bulk-deactivate'];

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

        $filters = $model->getFilters()->select('name')->column();

        $roles = $permissions = [];
        $children = $authManager->getChildren($model->name);
        foreach ($children as $child) {
            if($child->type == Role::TYPE_ROLE){
                $roles[] = $child->name;
            } elseif($child->type == Permission::TYPE_PERMISSION){
                $permissions[] = $child->name;
            } 
        }
        
        $dynamicModel = new DynamicModel(['roles', 'permissions', 'filters']);
        $dynamicModel->addRule(['roles', 'permissions', 'filters'], 'safe');
        $dynamicModel->roles = $roles;
        $dynamicModel->filters = $filters;
        $dynamicModel->permissions = $permissions;

        if ($model->load(Yii::$app->request->post()) AND $model->save()) {

            $dynamicModel->load(Yii::$app->request->post());
            $dynamicModel->roles = is_array($dynamicModel->roles) ? $dynamicModel->roles : [];
            $dynamicModel->filters = is_array($dynamicModel->filters) ? $dynamicModel->filters : [];
            $dynamicModel->permissions = is_array($dynamicModel->permissions) ? $dynamicModel->permissions : [];

            $role = $authManager->getRole($model->name);

            //Filters
            $filtersToAdd = array_diff($dynamicModel->filters, $filters);
            $filtersToRemove = array_diff($filters, $dynamicModel->filters);

            $authManager->addFilterToRole($model->name, $filtersToAdd);
            $authManager->removeFilterFromRole($model->name, $filtersToRemove);

            //Roles
            $rolesToAdd = array_diff($dynamicModel->roles, $roles);
            $rolesToRemove = array_diff($roles, $dynamicModel->roles);

            foreach ($rolesToAdd as $roleName) {
                $authManager->addChild($role, $authManager->getRole($roleName));
            }

            foreach ($rolesToRemove as $roleName) {
                $authManager->removeChild($role, $authManager->getRole($roleName));
            }

            //Permissions
            $permissionsToAdd = array_diff($dynamicModel->permissions, $permissions);
            $permissionsToRemove = array_diff($permissions, $dynamicModel->permissions);

            foreach ($permissionsToAdd as $permissionName) {
                $authManager->addChild($role, $authManager->getPermission($permissionName));
            }

            foreach ($permissionsToRemove as $permissionName) {
                $authManager->removeChild($role, $authManager->getPermission($permissionName));
            }


            Yii::$app->cache->flush(); //TODO: more accurate clear

            Yii::$app->session->setFlash('success', Yii::t('yee', 'Your item has been updated.'));
            return $this->redirect($this->getRedirectPage('update', $model));
        }

        return $this->renderIsAjax($this->updateView, compact('model', 'dynamicModel'));
    }

}
