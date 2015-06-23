<?php

use yeesoft\usermanagement\components\GhostHtml;
use yeesoft\usermanagement\models\Role;
use yeesoft\usermanagement\models\User;
use yeesoft\usermanagement\UserManagementModule;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use webvimark\extensions\GridBulkActions\GridBulkActions;
use webvimark\extensions\GridPageSize\GridPageSize;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var yeesoft\usermanagement\models\search\UserSearch $searchModel
 */
$this->title = UserManagementModule::t('back', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h2 class="lte-hide-title"><?= $this->title ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <p>
                        <?=
                        GhostHtml::a(
                                '<span class="glyphicon glyphicon-plus-sign"></span> ' . UserManagementModule::t('back', 'Create'), ['/user/create'], ['class' => 'btn btn-success']
                        )
                        ?>
                    </p>
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
                'pager' => [
                    'options' => ['class' => 'pagination pagination-sm'],
                    'hideOnSinglePage' => true,
                    'lastPageLabel' => '>>',
                    'firstPageLabel' => '<<',
                ],
                'filterModel' => $searchModel,
                'layout' => '{items}<div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">{summary}' . GridBulkActions::widget(['gridId' => 'user-grid']) . '</div></div>',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'class' => 'webvimark\components\StatusColumn',
                        'attribute' => 'superadmin',
                        'visible' => Yii::$app->user->isSuperadmin,
                    ],
                    [
                        'attribute' => 'username',
                        'value' => function(User $model) {
                    return Html::a($model->username, ['view', 'id' => $model->id], ['data-pjax' => 0]);
                },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'email',
                        'format' => 'raw',
                        'visible' => User::hasPermission('viewUserEmail'),
                    ],
                    [
                        'class' => 'webvimark\components\StatusColumn',
                        'attribute' => 'email_confirmed',
                        'visible' => User::hasPermission('viewUserEmail'),
                    ],
                    [
                        'attribute' => 'gridRoleSearch',
                        'filter' => ArrayHelper::map(Role::getAvailableRoles(Yii::$app->user->isSuperAdmin), 'name', 'description'),
                        'value' => function(User $model) {
                    return implode(', ', ArrayHelper::map($model->roles, 'name', 'description'));
                },
                        'format' => 'raw',
                        'visible' => User::hasPermission('viewUserRoles'),
                    ],
                    [
                        'attribute' => 'registration_ip',
                        'value' => function(User $model) {
                    return Html::a($model->registration_ip, "http://ipinfo.io/" . $model->registration_ip, ["target" => "_blank"]);
                },
                        'format' => 'raw',
                        'visible' => User::hasPermission('viewRegistrationIp'),
                    ],

                    [
                        'class' => 'webvimark\components\StatusColumn',
                        'attribute' => 'status',
                        'optionsArray' => [
                            [User::STATUS_ACTIVE, UserManagementModule::t('back', 'Active'), 'success'],
                            [User::STATUS_INACTIVE, UserManagementModule::t('back', 'Inactive'), 'warning'],
                            [User::STATUS_BANNED, UserManagementModule::t('back', 'Banned'), 'danger'],
                        ],
                    ],
                    ['class' => 'yii\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'min-width:110px; text-align:center;'],
                        'template' => '{view} {update} {delete} {roles} {password}',
                        'buttons' => [
      
                            'roles' => function ($url, $model, $key) {
                                return GhostHtml::a('<span class="glyphicon glyphicon-user"></span>', ['/user-permission/set', 'id' => $model->id], [
                                    'title' => Yii::t('yii', 'Roles and Permissions'),
                                    'aria-label' => Yii::t('yii', 'Roles and Permissions'),
                                    'data-pjax' => '0',
                                    'visible' => User::canRoute('/user-permission/set'),
                                ]);
                            },
    
                            'password' => function ($url, $model, $key) {
                                return GhostHtml::a('<span class="glyphicon glyphicon-lock"></span>', ['change-password', 'id' => $model->id], [
                                    'title' => Yii::t('yii', 'Change Password'),
                                    'aria-label' => Yii::t('yii', 'Change Password'),
                                    'data-pjax' => '0',
                                ]);
                            },
                        ]
                    ],
                ],
            ]);
            ?>

            <?php Pjax::end() ?>

        </div>
    </div>
</div>
