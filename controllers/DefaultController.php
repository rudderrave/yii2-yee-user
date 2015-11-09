<?php

namespace yeesoft\user\controllers;

use yeesoft\controllers\admin\BaseController;
use yeesoft\models\User;
use Yii;
use yii\web\NotFoundHttpException;
use yeesoft\user\UserModule;

/**
 * DefaultController implements the CRUD actions for User model.
 */
class DefaultController extends BaseController
{
    /**
     * @var User
     */
    public $modelClass = 'yeesoft\models\User';

    /**
     * @var UserSearch
     */
    public $modelSearchClass = 'yeesoft\user\models\search\UserSearch';

    public $disabledActions = ['view'];

    /**
     * @return mixed|string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User(['scenario' => 'newUser']);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderIsAjax('create', compact('model'));
    }

    /**
     * @param int $id User ID
     *
     * @throws \yii\web\NotFoundHttpException
     * @return string
     */
    public function actionChangePassword($id)
    {
        $model = User::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException(UserModule::t('user', 'User not found') );
        }

        $model->scenario = 'changePassword';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderIsAjax('changePassword', compact('model'));
    }
}