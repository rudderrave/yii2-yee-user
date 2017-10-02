<?php

namespace yeesoft\user\controllers;

use Yii;
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

        $authManager = Yii::$app->authManager;

        $models = AuthModel::find()->asArray()->all();
        $selected = $model->getModels()->asArray()->all();

        if (Yii::$app->request->isPost) {

            $newModels = Yii::$app->request->post('models', []);
            $oldModels = ArrayHelper::getColumn($selected, 'id');

            $toRemove = array_diff($oldModels, $newModels);
            $toAdd = array_diff($newModels, $oldModels);

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
