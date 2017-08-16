<?php

namespace yeesoft\user\models;

use yeesoft\models\Route;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class RouteSearch extends Route
{

    public function rules()
    {
        return [
            [['controller', 'action', 'base_url'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Route::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => ['base_url' => SORT_ASC, 'controller' => SORT_ASC, 'action' => SORT_ASC],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'controller', $this->controller])
                ->andFilterWhere(['like', 'action', $this->action])
                ->andFilterWhere(['like', 'base_url', $this->base_url]);

        return $dataProvider;
    }

}
