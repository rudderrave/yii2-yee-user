<?php

use yeesoft\helpers\Html;
use yeesoft\models\Role;
use yeesoft\models\User;
use yeesoft\Yee;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var yeesoft\models\User $model
 */
$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-view">

    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>

    <div class="panel panel-default">
        <div class="panel-body">

            <p>
                <?=
                Html::a('Edit', ['/user/default/update', 'id' => $model->id],
                    ['class' => 'btn btn-sm btn-primary'])
                ?>
                <?=
                Html::a(
                    Yee::t('back', 'Change Password'),
                    ['/user/default/change-password', 'id' => $model->id],
                    ['class' => 'btn btn-sm btn-primary']
                )
                ?>
                <?=
                Html::a(
                    Yee::t('back', 'Roles and permissions'),
                    ['/user/user-permission/set', 'id' => $model->id],
                    ['class' => 'btn btn-sm btn-primary']
                )
                ?>
                <?=
                Html::a('Delete', ['/user/default/delete', 'id' => $model->id],
                    [
                        'class' => 'btn btn-sm btn-default',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this user?',
                            'method' => 'post',
                        ],
                    ])
                ?>
                <?=
                Html::a('Add New', ['/user/default/create'],
                    ['class' => 'btn btn-sm btn-primary pull-right'])
                ?>
            </p>


            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'status',
                        'value' => User::getStatusValue($model->status),
                    ],
                    'username',
                    [
                        'attribute' => 'email',
                        'value' => $model->email,
                        'format' => 'email',
                        'visible' => User::hasPermission('viewUserEmail'),
                    ],
                    [
                        'attribute' => 'email_confirmed',
                        'value' => $model->email_confirmed,
                        'format' => 'boolean',
                        'visible' => User::hasPermission('viewUserEmail'),
                    ],
                    [
                        'label' => Yee::t('back', 'Roles'),
                        'value' => implode('<br>',
                            ArrayHelper::map(Role::getUserRoles($model->id),
                                'name', 'description')),
                        'visible' => User::hasPermission('viewUserRoles'),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'bind_to_ip',
                        'visible' => User::hasPermission('bindUserToIp'),
                    ],
                    array(
                        'attribute' => 'registration_ip',
                        'value' => yii\helpers\Html::a($model->registration_ip,
                            "http://ipinfo.io/" . $model->registration_ip,
                            ["target" => "_blank"]),
                        'format' => 'raw',
                        'visible' => User::hasPermission('viewRegistrationIp'),
                    ),
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ])
            ?>

        </div>
    </div>

</div>