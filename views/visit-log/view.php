<?php

use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var yeesoft\models\UserVisitLog $model
 */
$this->title = Yii::t('yee/user', 'Log №{id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Visit Log'), 'url' => ['/user/visit-log/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'user_id',
                            'value' => @$model->user->username,
                        ],
                        [
                            'attribute' => 'visit_time',
                            'value' => $model->visitDatetime,
                        ],
                        'ip',
                        'language',
                        'os',
                        'browser',
                        'user_agent',
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
</div>