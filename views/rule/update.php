<?php

/**
 * @var yii\web\View $this
 * @var yeesoft\models\AuthItemGroup $model
 */
$this->title = Yii::t('yee/user', 'Update Permission Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Permission Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', compact('model')) ?>