<?php

/**
 * @var yeesoft\widgets\ActiveForm $form
 * @var yeesoft\models\AuthRole $model
 */
$this->title = Yii::t('yee/user', 'Update Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', compact('model')) ?>