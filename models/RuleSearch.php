<?php

namespace yeesoft\user\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yeesoft\models\Rule;

class RuleSearch extends Rule
{

    public function rules()
    {
        return [
            [['name', 'class_name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Rule::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'class_name', $this->class_name]);

        return $dataProvider;
    }

}
