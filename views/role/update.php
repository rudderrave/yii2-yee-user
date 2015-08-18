<?php
/**
 * @var yii\widgets\ActiveForm $form
 * @var yeesoft\models\Role $model
 */

use yeesoft\Yee;
use yii\helpers\Html;

$this->title = Yee::t('back', 'Editing role: ') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Users'), 'url' => ['/user']];
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="role-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>