<?php

namespace yeesoft\user\controllers;

use yeesoft\controllers\CrudController;

class RouteController extends CrudController
{

    public $disabledActions = ['view'];

    /**
     * @var \yeesoft\models\AuthRoute
     */
    public $modelClass = 'yeesoft\models\AuthRoute';

    /**
     * @var \yeesoft\user\models\AuthRouteSearch
     */
    public $modelSearchClass = 'yeesoft\user\models\AuthRouteSearch';

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

}
