<?php

namespace yeesoft\user\controllers;

use yeesoft\controllers\CrudController;

/**
 * GroupsController implements the CRUD actions for Group model.
 */
class GroupsController extends CrudController
{
    /**
     * @var \yeesoft\models\AuthGroup
     */
    public $modelClass = 'yeesoft\models\AuthGroup';

    /**
     * @var \yeesoft\user\models\AuthGroupSearch
     */
    public $modelSearchClass = 'yeesoft\user\models\AuthGroupSearch';

    public $disabledActions = ['view'];

    /**
     * Define redirect page after update, create, delete, etc
     *
     * @param string $action
     * @param Group $model
     *
     * @return string|array
     */
    protected function getRedirectPage($action, $model = null)
    {
        switch ($action) {
            case 'delete':
                return ['index'];
                break;
            case 'create':
                return ['update', 'id' => $model->name];
                break;
            default:
                return ['index'];
        }
    }
}