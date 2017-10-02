<?php

use yeesoft\grid\GridView;
use yeesoft\helpers\Html;
use yii\widgets\Pjax;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var yeesoft\user\models\search\PermissionSearch $searchModel
 * @var yii\web\View $this
 */
$this->title = Yii::t('yee/user', 'Routes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['description'] = 'YeeCMS 0.2.0';
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
                    'attribute' => 'controller',
                    'class' => 'yeesoft\grid\columns\TitleActionColumn',
                    'title' => function ($model) {
                        return Html::a($model->name, ['view', 'id' => $model->id], ['data-pjax' => 0]);
                    },
                    'filterOptions' => ['colspan' => 2],
                ],
                [
                    'attribute' => 'bundle',
                    'options' => ['style' => 'width:20%'],
                ],
                [
                    'attribute' => 'action',
                    'options' => ['style' => 'width:20%'],
                ],
                [
                    'attribute' => 'action',
                    'options' => ['style' => 'width:20%'],
                ],
            ],
        ]);
        ?>

        <?php Pjax::end() ?>
    </div>
</div>