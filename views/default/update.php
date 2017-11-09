<?php

use yeesoft\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yeesoft\models\User $model
 */
$this->title = Yii::t('yee', 'Update "{item}"', ['item' => Yii::t('yee/user', 'User')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('yee', 'Update');

$this->params['header-content'] = Html::a(Yii::t('yee/user', 'Update Password'), ['change-password', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']);
?>

<?= $this->render('_form', compact('model', 'dynamicModel', 'groupedPermissions', 'roles')) ?>