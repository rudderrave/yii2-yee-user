<?php

namespace yeesoft\user\controllers;

use Yii;
use yeesoft\usermanagement\models\UserVisitLog;
use yeesoft\usermanagement\models\search\UserVisitLogSearch;
use yeesoft\base\controllers\AdminDefaultController;

/**
 * UserVisitLogController implements the CRUD actions for UserVisitLog model.
 */
class UserVisitLogController extends AdminDefaultController {

    /**
     * @var UserVisitLog
     */
    public $modelClass = 'webvimark\modules\UserManagement\models\UserVisitLog';

    /**
     * @var UserVisitLogSearch
     */
    public $modelSearchClass = 'webvimark\modules\UserManagement\models\search\UserVisitLogSearch';
    public $enableOnlyActions = ['index', 'view', 'grid-page-size'];

}
