<?php

namespace yeesoft\user\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yeesoft\models\Rule;
use yeesoft\models\AuthModel;
use yeesoft\controllers\CrudController;

class FilterController extends CrudController
{

    /**
     * @var Rule
     */
    public $modelClass = 'yeesoft\models\Filter';

    /**
     * @var RuleSearch
     */
    public $modelSearchClass = 'yeesoft\user\models\FilterSearch';

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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /* @var $model \yeesoft\db\ActiveRecord */
        $model = new $this->modelClass;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('yee', 'Your item has been created.'));
            return $this->redirect($this->getRedirectPage('create', $model));
        } else {
            //print_r($model->getErrors());die;
        }

        return $this->renderIsAjax($this->createView, compact('model'));
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
        /* @var $model \yeesoft\models\Filter */
        $model = $this->findModel($id);

        $authManager = Yii::$app->authManager;

        $models = AuthModel::find()->asArray()->all();
        $selected = $model->getModels()->asArray()->all();

        if (Yii::$app->request->isPost) {

            $newModels = Yii::$app->request->post('models', []);
            $oldModels = ArrayHelper::getColumn($selected, 'id');

            $toRemove = array_diff($oldModels, $newModels);
            $toAdd = array_diff($newModels, $oldModels);
            
//            print_r($toRemove);
//            print_r($toAdd);
//            die;

            $model->unlinkModels($toRemove);
            $model->linkModels($toAdd);
        }

        if ($model->load(Yii::$app->request->post()) AND $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('yee', 'Your item has been updated.'));
            return $this->redirect($this->getRedirectPage('update', $model));
        }

        return $this->renderIsAjax($this->updateView, compact('model', 'models', 'selected'));
    }

}
