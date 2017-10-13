<?php

namespace yeesoft\user\controllers;

use Yii;
use yii\base\Model;
use yii\rbac\DbManager;
use yii\helpers\ArrayHelper;
use yeesoft\controllers\CrudController;
use yeesoft\helpers\AuthHelper;
use yeesoft\models\AuthPermission;
use yeesoft\models\AuthRole;
use yeesoft\user\models\AuthRoleSearch;
use yeesoft\models\AuthFilter;

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
     * @param string $id
     *
     * @return string
     */
    public function actionView($id)
    {
        $role = $this->findModel($id);

        $authManager = new DbManager();

        $allRoles = AuthRole::find()->asArray()
                ->andWhere('name != :current_name', [':current_name' => $id])
                ->all();

        $permissions = AuthPermission::find()
                ->joinWith('groups')
                ->all();

        $permissionsByGroup = [];
        foreach ($permissions as $permission) {
            $permissionsByGroup[@$permission->group->name][] = $permission;
        }

        $childRoles = $authManager->getChildren($role->name);

        $currentRoutesAndPermissions = AuthHelper::separateRoutesAndPermissions($authManager->getPermissionsByRole($role->name));

        $currentPermissions = $currentRoutesAndPermissions->permissions;

        $activeFilters = $models = AuthFilter::find()->asArray()->all();
        $selecedActiveFilters = $role->getFilters()->asArray()->all();

        return $this->renderIsAjax('view', compact('role', 'allRoles', 'childRoles', 'currentPermissions', 'permissionsByGroup', 'activeFilters', 'selecedActiveFilters'));
    }

    /**
     * Add or remove active filters.
     *
     * @param string $id
     *
     * @return \yii\web\Response
     */
    public function actionSetActiveFilters($id)
    {
        $role = $this->findModel($id);

        $selecedActiveFilters = $role->getFilters()->asArray()->all();

        $newFilters = Yii::$app->request->post('filters', []);
        $oldFilters = ArrayHelper::getColumn($selecedActiveFilters, 'id');

        $toRemove = array_diff($oldFilters, $newFilters);
        $toAdd = array_diff($newFilters, $oldFilters);

        $role->unlinkFilters($toRemove);
        $role->linkFilters($toAdd);

        Yii::$app->cache->flush(); //TODO: more accurate clear

        Yii::$app->session->setFlash('success', Yii::t('yee', 'Saved'));

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Add or remove child roles and return back to view
     *
     * @param string $id
     *
     * @return \yii\web\Response
     */
    public function actionSetChildRoles($id)
    {
        $role = $this->findModel($id);

        $newChildRoles = Yii::$app->request->post('child_roles', []);

        $children = (new DbManager())->getChildren($role->name);

        $oldChildRoles = [];

        foreach ($children as $child) {
            if ($child->type == AuthRole::TYPE_ROLE) {
                $oldChildRoles[$child->name] = $child->name;
            }
        }

        $toRemove = array_diff($oldChildRoles, $newChildRoles);
        $toAdd = array_diff($newChildRoles, $oldChildRoles);

        AuthRole::addChildren($role->name, $toAdd);
        AuthRole::removeChildren($role->name, $toRemove);

        Yii::$app->session->setFlash('success', Yii::t('yee', 'Saved'));

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Add or remove child permissions (including routes) and return back to view
     *
     * @param string $id
     *
     * @return \yii\web\Response
     */
    public function actionSetChildPermissions($id)
    {
        $role = $this->findModel($id);

        $newChildPermissions = Yii::$app->request->post('child_permissions', []);

        $oldChildPermissions = array_keys((new DbManager())->getPermissionsByRole($role->name));

        $toRemove = array_diff($oldChildPermissions, $newChildPermissions);
        $toAdd = array_diff($newChildPermissions, $oldChildPermissions);

        AuthRole::addChildren($role->name, $toAdd);
        AuthRole::removeChildren($role->name, $toRemove);

        Yii::$app->session->setFlash('success', Yii::t('yii', 'Saved'));

        return $this->redirect(['view', 'id' => $id]);
    }

}
