<?php

use yii\helpers\Html;
use yeesoft\usermanagement\UserManagementModule;

/**
 * @var yii\web\View $this
 * @var yeesoft\usermanagement\models\User $model
 */
$this->title                   = UserManagementModule::t('back', 'Editing user: ').' '.$model->username;
$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Users'), 'url' => ['/user']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = UserManagementModule::t('back', 'Editing');
?>

<div class="user-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>