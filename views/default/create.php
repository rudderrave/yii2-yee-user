<?php

use yii\helpers\Html;
use yeesoft\usermanagement\UserManagementModule;

/**
 * @var yii\web\View $this
 * @var yeesoft\usermanagement\models\User $model
 */
$this->title                   = UserManagementModule::t('back', 'User creation');
$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-create">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>