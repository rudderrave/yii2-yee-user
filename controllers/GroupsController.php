<?php

namespace yeesoft\user\controllers;

use yii\base\Model;
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
     * @inheritdoc
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

}
