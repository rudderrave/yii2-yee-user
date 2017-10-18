<?php

namespace yeesoft\user\controllers;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yeesoft\models\AuthModel;
use yeesoft\controllers\CrudController;

class FilterController extends CrudController
{

    /**
     * @var \yeesoft\models\AuthFilter
     */
    public $modelClass = 'yeesoft\models\AuthFilter';

    /**
     * @var \yeesoft\user\models\AuthFilterSearch
     */
    public $modelSearchClass = 'yeesoft\user\models\AuthFilterSearch';

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

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        /* @var $model \yeesoft\models\AuthFilter */
        $model = $this->findModel($id);
        $model->scenario = $this->getActionScenario($this->action->id);

        $authModels = AuthModel::find()->asArray()->all();
        $currentAuthModels = $model->getModels()->asArray()->all();

        if (Yii::$app->request->isPost) {
            /* @var $authManager \yeesoft\rbac\DbManager   */
            $authManager = Yii::$app->authManager;

            $request = Yii::$app->request->post('authModel', []);
            $current = ArrayHelper::getColumn($currentAuthModels, 'name');
            
            $authManager->removeModelFromFilter($model->name, array_diff($current, $request));
            $authManager->addModelToFilter($model->name, array_diff($request, $current));
        }

        if ($model->load(Yii::$app->request->post()) AND $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('yee', 'Your item has been updated.'));
            return $this->redirect($this->getRedirectPage('update', $model));
        }

        return $this->renderIsAjax($this->updateView, compact('model', 'authModels', 'currentAuthModels'));
    }

}
