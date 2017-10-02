<?php

namespace yeesoft\user\controllers;

use yeesoft\controllers\CrudController;
use yeesoft\helpers\AuthHelper;
use yeesoft\models\AuthItem;
use yeesoft\models\AuthPermission;
use yeesoft\models\AuthRoute;
use yeesoft\user\models\AuthPermissionSearch;
use Yii;
use yeesoft\rbac\ManagerInterface;

class PermissionController extends CrudController
{
    /**
     * @var Permission
     */
    public $modelClass = 'yeesoft\models\AuthPermission';

    /**
     * @var PermissionSearch
     */
    public $modelSearchClass = 'yeesoft\user\models\AuthPermissionSearch';

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_AFTER_ACTION, [$this, 'flushCache']);
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
                ->joinWith('group')
                ->all();

        foreach ($permissions as $permission) {
            $result[@$permission->group->name][] = $permission;
        }

        return $result;
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function actionView($id)
    {
        $item = $this->findModel($id);

        $routes = $this->getRoutes();
        $permissions = $this->getPermissions($id);
        $selectedRoutes = $item->getRoutes()->select('id')->column();
        $selectedPermissions = AuthHelper::getChildrenByType($item->name, AuthItem::TYPE_PERMISSION);

        return $this->renderIsAjax('view', compact('item', 'routes', 'permissions', 'selectedRoutes', 'selectedPermissions'));
    }

    /**
     * Add or remove child permissions (including routes) and return back to view
     *
     * @param string $id
     *
     * @return string|\yii\web\Response
     */
    public function actionSetPermissions($id)
    {
        /* @var $item AuthPermission */
        $item = $this->findModel($id);

        $newPermissions = Yii::$app->request->post('child_permissions', []);
        $oldPermissions = array_keys(AuthHelper::getChildrenByType($item->name, AuthItem::TYPE_PERMISSION));

        $toRemove = array_diff($oldPermissions, $newPermissions);
        $toAdd = array_diff($newPermissions, $oldPermissions);

        AuthPermission::addChildren($item->name, $toAdd);
        AuthPermission::removeChildren($item->name, $toRemove);

        Yii::$app->session->setFlash('success', Yii::t('yee', 'Saved'));

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Add or remove routes for this permission
     *
     * @param string $id
     *
     * @return \yii\web\Response
     */
    public function actionSetRoutes($id)
    {
        /* @var $item AuthPermission */
        $item = $this->findModel($id);

        $newRoutes = Yii::$app->request->post('child_routes', []);
        $oldRoutes = $item->getRoutes()->select('id')->column();

        $toAdd = array_diff($newRoutes, $oldRoutes);
        $toRemove = array_diff($oldRoutes, $newRoutes);

        $item->linkRoutes($toAdd);
        $item->unlinkRoutes($toRemove);

        AuthHelper::invalidatePermissions();

        Yii::$app->session->setFlash('success', Yii::t('yee', 'Saved'));

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthPermission();
        //$model->scenario = 'webInput';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->renderIsAjax('create', compact('model'));
    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'webInput';

        if ($model->load(Yii::$app->request->post()) AND $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->renderIsAjax('update', compact('model'));
    }

}
