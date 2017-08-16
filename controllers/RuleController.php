<?php

namespace yeesoft\user\controllers;

use Yii;
use yeesoft\models\Rule;
use yeesoft\controllers\CrudController;

class RuleController extends CrudController
{

    /**
     * @var Rule
     */
    public $modelClass = 'yeesoft\models\Rule';

    /**
     * @var RuleSearch
     */
    public $modelSearchClass = 'yeesoft\user\models\RuleSearch';

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
