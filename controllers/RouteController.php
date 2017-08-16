<?php

namespace yeesoft\user\controllers;

use Yii;
use yeesoft\models\Route;
use yeesoft\user\models\RouteSearch;
use yeesoft\controllers\CrudController;

class RouteController extends CrudController
{

    public $disabledActions = ['view'];

    /**
     * @var Route
     */
    public $modelClass = 'yeesoft\models\Route';

    /**
     * @var RouteSearch
     */
    public $modelSearchClass = 'yeesoft\user\models\RouteSearch';

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
