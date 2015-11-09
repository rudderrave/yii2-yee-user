<?php
/**
 * @var yii\widgets\ActiveForm $form
 * @var yeesoft\models\Role $model
 */

use yeesoft\Yee;
use yii\helpers\Html;
use yeesoft\user\UserModule;

$this->title = UserModule::t('user', 'Update Role');
$this->params['breadcrumbs'][] = ['label' => UserModule::t('user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = ['label' => UserModule::t('user', 'Roles'), 'url' => ['/user/role/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="role-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>