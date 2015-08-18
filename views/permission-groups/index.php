<?php

use webvimark\extensions\GridPageSize\GridPageSize;
use yeesoft\grid\GridView;
use yeesoft\helpers\Html;
use yeesoft\Yee;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var yeesoft\user\models\search\AuthItemGroupSearch $searchModel
 */
$this->title = Yee::t('back', 'Permission groups');
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Users'), 'url' => ['/user']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="permission-groups-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a('Add New', ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-12 text-right">
                    <?= GridPageSize::widget(['pjaxId' => 'permission-groups-grid-pjax']) ?>
                </div>
            </div>

            <?php
            Pjax::begin([
                'id' => 'permission-groups-grid-pjax',
            ])
            ?>

            <?=
            GridView::widget([
                'id' => 'permission-groups-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActionOptions' => [
                    'gridId' => 'permission-grid',
                    'actions' => [Url::to(['bulk-delete']) => 'Delete']
                ],
                'columns' => [
                    ['class' => 'yii\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'attribute' => 'name',
                        'class' => 'yeesoft\grid\columns\TitleActionColumn',
                        'title' => function ($model) {
                            return Html::a(
                                $model->name, ['update', 'id' => $model->code],
                                ['data-pjax' => 0]
                            );
                        },
                    ],
                    'code',
                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>

































