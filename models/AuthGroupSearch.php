<?php

namespace yeesoft\user\models;

use yeesoft\models\AuthGroup;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AuthGroupSearch represents the model behind the search form about `yeesoft\models\AuthGroup`.
 */
class AuthGroupSearch extends AuthGroup
{

    public function rules()
    {
        return [
            [['name', 'title'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = parent::find();

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

        $query->andFilterWhere(['like', Yii::$app->authManager->groupTable . '.name', $this->name])
                ->andFilterWhere(['like', Yii::$app->authManager->groupTable . '.title', $this->title]);

        return $dataProvider;
    }

}
