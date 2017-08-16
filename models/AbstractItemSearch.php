<?php

namespace yeesoft\user\models;

use yeesoft\models\AbstractItem;
use yeesoft\models\Permission;
use yeesoft\models\Role;
use yeesoft\models\Route;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

abstract class AbstractItemSearch extends AbstractItem
{

    public function rules()
    {
        return [
            [['name', 'description', 'group_code', 'rule_name'], 'string'],
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
                $query = Role::find();
                break;

            case static::TYPE_PERMISSION:
                $query = Permission::find();
                break;

            case static::TYPE_ROUTE:
                $query = Route::find();
                break;

            default:
                throw new \yii\base\InvalidParamException('Invalid Auth Type.');
        }

        $query->joinWith(['group']);

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
        
        $query->andFilterWhere(['like', Yii::$app->yee->auth_item_table . '.name', $this->name])
                ->andFilterWhere(['like', Yii::$app->yee->auth_item_table . '.description', $this->description])
                ->andFilterWhere([Yii::$app->yee->auth_item_table . '.group_code' => $this->group_code]);

        return $dataProvider;
    }

}
