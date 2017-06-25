<?php

/**
 * @var yii\web\View $this
 * @var yeesoft\models\User $model
 */
$this->title = Yii::t('yee', 'Update "{item}"', ['item' => Yii::t('yee/user', 'User')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('yee', 'Update');
?>

<?= $this->render('_form', compact('model')) ?>