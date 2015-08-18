<?php

use yeesoft\Yee;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yeesoft\models\User $model
 */
$this->title = Yee::t('back', 'User creation');
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-create">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>