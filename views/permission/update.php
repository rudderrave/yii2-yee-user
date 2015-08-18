<?php
/**
 * @var yii\widgets\ActiveForm $form
 * @var yeesoft\models\Permission $model
 */

use yeesoft\Yee;
use yii\helpers\Html;

$this->title = Yee::t('back', 'Editing permission: ') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Users'), 'url' => ['/user']];
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="permission-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>