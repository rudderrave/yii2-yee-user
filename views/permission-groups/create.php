<?php

use yeesoft\Yee;
use yii\helpers\Html;
use yeesoft\user\UserModule;

/**
 * @var yii\web\View $this
 * @var yeesoft\models\AuthItemGroup $model
 */

$this->title = UserModule::t('user', 'Create Permission Group');
$this->params['breadcrumbs'][] = ['label' => UserModule::t('user', 'Users'), 'url' => ['/user']];
$this->params['breadcrumbs'][] = ['label' => UserModule::t('user', 'Permission Groups'), 'url' => ['/user/permission-groups/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="permission-groups-create">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>
