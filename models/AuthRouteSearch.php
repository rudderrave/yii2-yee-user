<?php

namespace yeesoft\user\models;

use yeesoft\models\AuthRoute;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AuthRouteSearch extends AuthRoute
{

    public function rules()
    {
        return [
            [['controller', 'action', 'bundle'], 'safe'],
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
        $query = parent::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => ['bundle' => SORT_ASC, 'controller' => SORT_ASC, 'action' => SORT_ASC],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'controller', $this->controller])
                ->andFilterWhere(['like', 'action', $this->action])
                ->andFilterWhere(['like', 'bundle', $this->bundle]);

        return $dataProvider;
    }

}
