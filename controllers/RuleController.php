<?php

namespace yeesoft\user\controllers;

use yeesoft\controllers\CrudController;

class RuleController extends CrudController
{

    /**
     * @var \yeesoft\models\AuthRule
     */
    public $modelClass = 'yeesoft\models\AuthRule';

    /**
     * @var \yeesoft\user\models\AuthRuleSearch
     */
    public $modelSearchClass = 'yeesoft\user\models\AuthRuleSearch';

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

}
