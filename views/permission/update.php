<?php

/**
 * @var yeesoft\widgets\ActiveForm $form
 * @var yeesoft\models\AuthPermission $model
 */
$this->title = Yii::t('yee/user', 'Update Permission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Permissions'), 'url' => ['/user/permission/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', compact('model')) ?>