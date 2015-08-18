<?php

use yeesoft\Yee;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var yeesoft\models\UserVisitLog $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Users'), 'url' => ['/user']];
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Visit log'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-visit-log-view">


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
