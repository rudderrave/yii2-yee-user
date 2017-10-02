<?php

/**
 * @var yii\web\View $this
 * @var yeesoft\models\AuthRule $model
 */
$this->title = Yii::t('yee/user', 'Create Rule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', compact('model')) ?>