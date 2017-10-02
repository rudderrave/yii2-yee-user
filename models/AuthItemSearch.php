<?php

namespace yeesoft\user\models;

use yeesoft\models\AuthItem;
use yeesoft\models\AuthPermission;
use yeesoft\models\AuthRole;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

abstract class AuthItemSearch extends AuthItem
{

    public function rules()
    {
        return [
            [['name', 'description', 'rule_name'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        switch (static::ITEM_TYPE) {
            case static::TYPE_ROLE:
                $query = AuthRole::find();
                break;

            case static::TYPE_PERMISSION:
                $query = AuthPermission::find();
                break;

            default:
                throw new \yii\base\InvalidParamException('Invalid Auth Type.');
        }

        //$query->joinWith(['group']);

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
                ->andFilterWhere(['like', Yii::$app->authManager->itemTable . '.description', $this->description])
                ;//->andFilterWhere([Yii::$app->authManager->itemTable . '.group_name' => $this->group_name]);

        return $dataProvider;
    }

}
