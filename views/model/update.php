<?php

/**
 * @var yii\web\View $this
 * @var yeesoft\models\AuthModel $model
 */
$this->title = Yii::t('yee/user', 'Update Model');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', compact('model')) ?>