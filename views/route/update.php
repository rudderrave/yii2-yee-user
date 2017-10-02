<?php

/**
 * @var yeesoft\widgets\ActiveForm $form
 * @var yeesoft\models\AuthPermission $model
 */
$this->title = Yii::t('yee/user', 'Update Route');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Routes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', compact('model')) ?>