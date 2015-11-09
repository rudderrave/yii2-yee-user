<?php

use yeesoft\Yee;
use yii\helpers\Html;
use yeesoft\user\UserModule;

/**
 * @var yii\web\View $this
 * @var yeesoft\models\User $model
 */
$this->title = UserModule::t('user', 'Create User');
$this->params['breadcrumbs'][] = ['label' => UserModule::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-create">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>