<?php

use yeesoft\grid\GridPageSize;
use yeesoft\grid\GridView;
use yeesoft\helpers\Html;
use yeesoft\models\AuthItemGroup;
use yeesoft\models\Permission;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var yeesoft\user\models\search\PermissionSearch $searchModel
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
                    'controller' => '/user/permission',
                    'title' => function ($model) {
                        return Html::a(
                                        $model->description, ['view', 'id' => $model->name], (($model->name == Yii::$app->yee->commonPermissionName)) ? ['data-pjax' => 0, 'class' => 'label label-primary'] : ['data-pjax' => 0]
                        );
                    },
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            $options = array_merge([
                                'title' => Yii::t('yee', 'Settings'),
                                'aria-label' => Yii::t('yee', 'Settings'),
                                'data-pjax' => '0',
                            ]);
                            return Html::a(Yii::t('yee', 'Settings'), $url, $options);
                        }
                    ],
                    'filterOptions' => ['colspan' => 2],
                ],
                [
                    'attribute' => 'name',
                    'options' => ['style' => 'width:150px'],
                ],
                [
                    'attribute' => 'group_code',
                    'filter' => ArrayHelper::map(AuthItemGroup::find()->asArray()->all(), 'code', 'name'),
                    'value' => function (Permission $model) {
                        return $model->group_code ? $model->group->name : '';
                    },
                    'options' => ['style' => 'width:150px'],
                ],
            ],
        ]);
        ?>

        <?php Pjax::end() ?>
    </div>
</div>