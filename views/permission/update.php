<?php
/**
 * @var yii\widgets\ActiveForm $form
 * @var yeesoft\models\Permission $model
 */

use yeesoft\Yee;
use yii\helpers\Html;
use yeesoft\user\UserModule;

$this->title = UserModule::t('user', 'Update Permission');
$this->params['breadcrumbs'][] = ['label' => UserModule::t('user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = ['label' => UserModule::t('user', 'Permissions'), 'url' => ['/user/permission/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="permission-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>