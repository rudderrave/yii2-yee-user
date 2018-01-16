<?php

namespace yeesoft\user\models;

use Yii;
use yii\base\Model;
use yeesoft\data\ActiveDataProvider;
use yeesoft\models\AuthPermission;

class AuthPermissionSearch extends AuthPermission
{

    const ITEM_TYPE = self::TYPE_PERMISSION;

    public function rules()
    {
        return [
            [['name', 'groupName', 'rule_name', 'description'], 'string'],
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
        $query = parent::find()->joinWith(['groups']);

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
                ->andFilterWhere([Yii::$app->authManager->groupTable . '.name' => $this->groupName]);

        return $dataProvider;
    }

}
