<?php

use yeesoft\Yee;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yeesoft\models\AuthItemGroup $model
 */

$this->title = Yee::t('back', 'Creating permission group');
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Users'), 'url' => ['/user']];
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Permission groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="permission-groups-create">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>
