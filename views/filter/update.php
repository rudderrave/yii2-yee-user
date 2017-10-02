<?php

/**
 * @var yii\web\View $this
 * @var yeesoft\models\AuthFilter $model
 */
$this->title = Yii::t('yee/user', 'Update Query Filter');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Query Filters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', compact('model', 'models', 'selected')) ?>