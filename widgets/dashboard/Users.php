<?php

namespace yeesoft\user\widgets\dashboard;

use yeesoft\models\User;
use yeesoft\user\models\search\UserSearch;

class Users extends \yii\base\Widget
{
    /**
     * Widget height
     */
    public $height = 'auto';

    /**
     * Widget width
     */
    public $width = '8';

    /**
     * Widget position
     *
     * @var string
     */
    public $position = 'left';

    /**
     * Most recent post limit
     */
    public $recentLimit = 5;

    /**
     * Post index action
     */
    public $indexAction = 'user/default/index';

    /**
     * Total count options
     *
     * @var array
     */
    public $options = [
        ['label' => 'Active', 'icon' => 'ok', 'filterWhere' => ['status' => User::STATUS_ACTIVE]],
        ['label' => 'Inactive', 'icon' => 'ok', 'filterWhere' => ['status' => User::STATUS_INACTIVE]],
        ['label' => 'Banned', 'icon' => 'ok', 'filterWhere' => ['status' => User::STATUS_BANNED]],
    ];

    public function run()
    {
        $searchModel = new UserSearch();
        $formName = $searchModel->formName();

        $recent = User::find()->orderBy(['id' => SORT_DESC])->limit($this->recentLimit)->all();

        foreach ($this->options as &$option) {
            $count = User::find()->filterWhere($option['filterWhere'])->count();
            $option['count'] = $count;
            $option['url'] = [$this->indexAction, $formName => $option['filterWhere']];
        }

        return $this->render('users', [
            'height' => $this->height,
            'width' => $this->width,
            'position' => $this->position,
            'users' => $this->options,
            'recent' => $recent,
        ]);
    }
}