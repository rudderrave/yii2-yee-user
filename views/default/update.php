<?php

use yeesoft\Yee;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yeesoft\models\User $model
 */
$this->title = Yee::t('back', 'Editing user: ') . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Users'), 'url' => ['/user']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yee::t('back', 'Editing');
?>

<div class="user-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>