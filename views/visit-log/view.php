<?php

use yeesoft\Yee;
use yii\widgets\DetailView;
use yeesoft\user\UserModule;

/**
 * @var yii\web\View $this
 * @var yeesoft\models\UserVisitLog $model
 */

$this->title = UserModule::t('user', 'Log №{id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => UserModule::t('user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = ['label' => UserModule::t('user', 'Visit Log'), 'url' => ['/user/visit-log/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-visit-log-view">

    <h3 class="lte-hide-title"><?= $this->title ?></h3>

    <div class="panel panel-default">
        <div class="panel-body">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'user_id',
                        'value' => @$model->user->username,
                    ],
                    'ip',
                    'language',
                    'os',
                    'browser',
                    'user_agent',
                    'visit_time:datetime',
                ],
            ]) ?>

        </div>
    </div>
</div>
