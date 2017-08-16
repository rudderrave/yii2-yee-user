<?php

namespace yeesoft\user\controllers;

use yeesoft\controllers\CrudController;

/**
 * UserVisitLogController implements the CRUD actions for UserVisitLog model.
 */
class VisitLogController extends CrudController
{
    /**
     *
     * @inheritdoc
     */
    public $modelClass = 'yeesoft\models\UserVisitLog';

    /**
     *
     * @inheritdoc
     */
    public $modelSearchClass = 'yeesoft\user\models\UserVisitLogSearch';

    /**
     *
     * @inheritdoc
     */
    public $enableOnlyActions = ['index', 'view', 'grid-page-size'];

}