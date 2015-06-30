<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yeesoft\grid\GridView;
use yeesoft\usermanagement\models\Role;
use yeesoft\usermanagement\models\User;
use yeesoft\gridquicklinks\GridQuickLinks;
use yeesoft\usermanagement\components\GhostHtml;
use yeesoft\usermanagement\UserManagementModule;
use webvimark\extensions\GridPageSize\GridPageSize;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var yeesoft\usermanagement\models\search\UserSearch $searchModel
 */
$this->title                   = UserManagementModule::t('back', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?=
            GhostHtml::a('Add New', ['create'],
                ['class' => 'btn btn-sm btn-primary'])
            ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <?=
                    GridQuickLinks::widget([
                        'model' => User::class,
                        'searchModel' => $searchModel,
                    ])
                    ?>
                </div>

                <div class="col-sm-6 text-right">
                    <?= GridPageSize::widget(['pjaxId' => 'user-grid-pjax']) ?>
                </div>
            </div>

            <?php
            Pjax::begin([
                'id' => 'user-grid-pjax',
            ])
            ?>

            <?=
            GridView::widget([
                'id' => 'user-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActionOptions' => [
                    'gridId' => 'user-grid',
                ],
                'columns' => [
                    ['class' => 'yii\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'attribute' => 'username',
                        'class' => 'yeesoft\grid\columns\TitleActionColumn',
                        'title' => function(User $model) {
                        return Html::a($model->username,
                                ['view', 'id' => $model->id], ['data-pjax' => 0]);
                    },
                        'buttonsTemplate' => '{update} {delete} {view} {permissions} {password}',
                        'buttons' => [
                            'permissions' => function ($url, $model, $key) {
                            return Html::a('Permissions',
                                    Url::to(['user-permission/set', 'id' => $model->id]),
                                    [
                                    'title' => 'Permissions',
                                    'data-pjax' => '0'
                                    ]
                            );
                        },
                            'password' => function ($url, $model, $key) {
                            return Html::a('Password',
                                    Url::to(['default/change-password', 'id' => $model->id]),
                                    [
                                    'title' => 'Password',
                                    'data-pjax' => '0'
                                    ]
                            );
                        }
                        ],
                        'options' => ['style' => 'width:300px']
                    ],
                    [
                        'attribute' => 'email',
                        'format' => 'raw',
                        'visible' => User::hasPermission('viewUserEmail'),
                    ],
                    /* [
                      'class' => 'yeesoft\grid\columns\StatusColumn',
                      'attribute' => 'email_confirmed',
                      'visible' => User::hasPermission('viewUserEmail'),
                      ], */
                    [
                        'attribute' => 'gridRoleSearch',
                        'filter' => ArrayHelper::map(Role::getAvailableRoles(Yii::$app->user->isSuperAdmin),
                            'name', 'description'),
                        'value' => function(User $model) {
                        return implode(', ',
                            ArrayHelper::map($model->roles, 'name',
                                'description'));
                    },
                        'format' => 'raw',
                        'visible' => User::hasPermission('viewUserRoles'),
                        'filterInputOptions' => [],
                    ],
                    /*  [
                      'attribute' => 'registration_ip',
                      'value' => function(User $model) {
                      return Html::a($model->registration_ip,
                      "http://ipinfo.io/".$model->registration_ip,
                      ["target" => "_blank"]);
                      },
                      'format' => 'raw',
                      'visible' => User::hasPermission('viewRegistrationIp'),
                      ], */
                    [
                        'class' => 'yeesoft\grid\columns\StatusColumn',
                        'attribute' => 'superadmin',
                        'visible' => Yii::$app->user->isSuperadmin,
                    ],
                    [
                        'class' => 'yeesoft\grid\columns\StatusColumn',
                        'attribute' => 'status',
                        'optionsArray' => [
                            [User::STATUS_ACTIVE, UserManagementModule::t('back',
                                    'Active'), 'primary'],
                            [User::STATUS_INACTIVE, UserManagementModule::t('back',
                                    'Inactive'), 'info'],
                            [User::STATUS_BANNED, UserManagementModule::t('back',
                                    'Banned'), 'default'],
                        ],
                    ],
                ],
            ]);
            ?>

            <?php Pjax::end() ?>

        </div>
    </div>
</div>
