<?php

use yeesoft\Yee;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yeesoft\models\AuthItemGroup $model
 */

$this->title = Yee::t('back', 'Editing permission group') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Users'), 'url' => ['/user']];
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Permission groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->code]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Editing')
?>

<div class="permission-groups-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>
