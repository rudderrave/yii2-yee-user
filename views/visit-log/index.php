<?php

use webvimark\extensions\DateRangePicker\DateRangePicker;
use yeesoft\grid\GridPageSize;
use yeesoft\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var yeesoft\user\models\search\UserVisitLogSearch $searchModel
 */
$this->title = Yii::t('yee/user', 'Visit Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['description'] = 'YeeCMS 0.2.0';
?>

<div class="box box-primary">
    <div class="box-body">
        <?php $pjax = Pjax::begin() ?>
        <?=
        GridView::widget([
            'pjaxId' => $pjax->id,
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'bulkActions' => false,
            'quickFilters' => false,
            'columns' => [
                [
                    'attribute' => 'user_id',
                    'value' => function ($model) {
                        return Html::a(@$model->user->username, ['view', 'id' => $model->id], ['data-pjax' => 0]);
                    },
                    'format' => 'raw',
                ],
                'language',
                'os',
                'browser',
                array(
                    'attribute' => 'ip',
                    'value' => function ($model) {
                        return Html::a($model->ip, "http://ipinfo.io/" . $model->ip, ["target" => "_blank"]);
                    },
                    'format' => 'raw',
                ),
                [
                    'attribute' => 'visit_time',
                    'value' => function ($model) {
                        return $model->visitDatetime;
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'contentOptions' => ['style' => 'width:70px; text-align:center;'],
                ],
            /* [
              'attribute' => 'author_id',
              'filter' => yeesoft\models\User::getUsersList(),
              'value' => function(Post $model) {
              return Html::a($model->author->username,
              ['user/view', 'id' => $model->author_id],
              ['data-pjax' => 0]);
              },
              'format' => 'raw',
              'options' => ['style' => 'width:180px'],
              ],
              [
              'class' => 'yeesoft\grid\columns\StatusColumn',
              'attribute' => 'status',
              'optionsArray' => Post::getStatusOptionsList(),
              'options' => ['style' => 'width:60px'],
              ],
              [
              'class' => 'yeesoft\grid\columns\DateFilterColumn',
              'attribute' => 'published_at',
              'value' => function(Post $model) {
              return '<span style="font-size:85%;" class="label label-'
              .((time() >= $model->published_at) ? 'primary' : 'default').'">'
              .$model->publishedDate.'</span>';
              },
              'format' => 'raw',
              'options' => ['style' => 'width:150px'],
              ], */
            ],
        ]);
        ?>

        <?php Pjax::end() ?>
    </div>
</div>


<?php
DateRangePicker::widget([
    'model' => $searchModel,
    'attribute' => 'visit_time',
])
?>