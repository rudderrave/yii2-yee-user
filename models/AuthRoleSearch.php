<?php

namespace yeesoft\user\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yeesoft\models\AuthRole;

class AuthRoleSearch extends AuthRole
{

    public function rules()
    {
        return [
            [['name', 'description', 'rule_name'], 'string'],
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
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['rule_name' => $this->rule_name]);

        $query->andFilterWhere(['like', Yii::$app->authManager->itemTable . '.name', $this->name])
                ->andFilterWhere(['like', Yii::$app->authManager->itemTable . '.description', $this->description]);

        return $dataProvider;
    }

}
