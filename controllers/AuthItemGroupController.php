<?php

namespace yeesoft\user\controllers;

use yeesoft\base\controllers\AdminDefaultController;
use yeesoft\usermanagement\models\AuthItemGroup;
use yeesoft\usermanagement\models\search\AuthItemGroupSearch;

/**
 * AuthItemGroupController implements the CRUD actions for AuthItemGroup model.
 */
class AuthItemGroupController extends AdminDefaultController {

    /**
     * @var AuthItemGroup
     */
    public $modelClass = 'yeesoft\usermanagement\models\AuthItemGroup';

    /**
     * @var AuthItemGroupSearch
     */
    public $modelSearchClass = 'yeesoft\usermanagement\models\search\AuthItemGroupSearch';

    /**
     * Define redirect page after update, create, delete, etc
     *
     * @param string       $action
     * @param AuthItemGroup $model
     *
     * @return string|array
     */
    protected function getRedirectPage($action, $model = null) {
        switch ($action) {
            case 'delete':
                return ['index'];
                break;
            case 'update':
                return ['view', 'id' => $model->code];
                break;
            case 'create':
                return ['view', 'id' => $model->code];
                break;
            default:
                return ['index'];
        }
    }

}
