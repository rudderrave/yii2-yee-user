<?php

use yeesoft\grid\GridView;
use yeesoft\helpers\Html;
use yeesoft\models\AuthRole;
use yeesoft\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var yeesoft\user\models\search\UserSearch $searchModel
 */
$this->title = Yii::t('yee/user', 'Users');
$this->params['description'] = 'YeeCMS 0.2.0';
$this->params['breadcrumbs'][] = $this->title;
$this->params['header-content'] = Html::a(Yii::t('yee', 'Add New'), ['create'], ['class' => 'btn btn-sm btn-primary']);
?>
<div class="box box-primary">
    <div class="box-body">
        <?php $pjax = Pjax::begin() ?>
        <?=
        GridView::widget([
            'pjaxId' => $pjax->id,
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'quickFilters' => false,
            'columns' => [
                ['class' => 'yeesoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px'], 'displayFilter' => false],
                [
                    'attribute' => 'username',
                    'class' => 'yeesoft\grid\columns\TitleActionColumn',
                    'title' => function (User $model) {
                        if (Yii::$app->user->can('update-users')) {
                            return Html::a($model->username, ['/user/default/update', 'id' => $model->id], ['data-pjax' => 0]);
                        } else {
                            return $model->username;
                        }
                    },
                    'buttonsTemplate' => '{update} {profile} {delete}',
                    'buttons' => [
                        'profile' => function ($url, $model, $key) {
                            return Html::a(Yii::t('yee/user', 'Profile'), Url::to(['/auth/profile/index', 'id' => $model->id]), ['data-pjax' => '0']);
                        }
                    ],
                    'filterOptions' => ['colspan' => 2],
                    'options' => ['style' => 'width:20%']
                ],
                [
                    'attribute' => 'email',
                    'format' => 'raw',
                    'visible' => Yii::$app->user->can('view-user-email'),
                    'options' => ['style' => 'width:20%']
                ],
                [
                    'attribute' => 'first_name',
                    'options' => ['style' => 'width:15%']
                ],
                [
                    'attribute' => 'last_name',
                    'options' => ['style' => 'width:15%']
                ],
                [
                    'attribute' => 'gridRoleSearch',
                    'filter' => AuthRole::getRoles(),
                    'value' => function (User $model) {
                        return implode(', ', ArrayHelper::map($model->roles, 'name', 'description'));
                    },
                    'format' => 'raw',
                    'visible' => Yii::$app->user->can('view-user-roles'),
                    'options' => ['style' => 'width:20%']
                ],
                [
                    'class' => 'yeesoft\grid\columns\StatusColumn',
                    'attribute' => 'superadmin',
                    'visible' => Yii::$app->user->isSuperadmin,
                    'options' => ['style' => 'width:80px']
                ],
                [
                    'class' => 'yeesoft\grid\columns\StatusColumn',
                    'attribute' => 'email_confirmed',
                    'visible' => Yii::$app->user->can('view-user-email'),
                    'options' => ['style' => 'width:80px']
                ],
                [
                    'class' => 'yeesoft\grid\columns\StatusColumn',
                    'attribute' => 'status',
                    'optionsArray' => [
                        [User::STATUS_ACTIVE, Yii::t('yee', 'Active'), 'primary'],
                        [User::STATUS_INACTIVE, Yii::t('yee', 'Inactive'), 'info'],
                        [User::STATUS_BANNED, Yii::t('yee', 'Banned'), 'default'],
                    ],
                    'options' => ['style' => 'width:80px']
                ],
            ],
        ]);
        ?>
        <?php Pjax::end() ?>
    </div>
</div>