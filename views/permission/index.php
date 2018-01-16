<?php

use yeesoft\grid\GridView;
use yeesoft\helpers\Html;
use yeesoft\models\AuthGroup;
use yeesoft\models\AuthPermission;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

/**
 * @var yeesoft\data\ActiveDataProvider $dataProvider
 * @var yeesoft\user\models\search\AuthPermissionSearch $searchModel
 * @var yii\web\View $this
 */
$this->title = Yii::t('yee/user', 'Permissions');
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
                    'attribute' => 'description',
                    'class' => 'yeesoft\grid\columns\TitleActionColumn',
                    'title' => function ($model) {
                        return Html::a($model->description, ['update', 'id' => $model->name], ['data-pjax' => 0]);
                    },
                    'buttonsTemplate' => '{update} {delete}',
                    'filterOptions' => ['colspan' => 2],
                ],
                [
                    'attribute' => 'name',
                    'options' => ['style' => 'width:30%'],
                ],
                [
                    'attribute' => 'groupName',
                    'filter' => ArrayHelper::map(AuthGroup::find()->asArray()->all(), 'name', 'title'),
                    'value' => function (AuthPermission $model) {
                        return $model->groupName ? $model->group->title : '';
                    },
                    'options' => ['style' => 'width:30%'],
                ],
            ],
        ]);
        ?>

        <?php Pjax::end() ?>
    </div>
</div>