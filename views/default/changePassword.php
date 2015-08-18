<?php

use yeesoft\Yee;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yeesoft\models\User $model
 */
$this->title = Yee::t('back', 'Changing password for user: ') . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yee::t('back', 'Changing password');
?>
<div class="user-update">

    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="user-form">

                <?php
                $form = ActiveForm::begin([
                    'id' => 'user',
                    'layout' => 'horizontal',
                ]);
                ?>

                <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>

                <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <?php if ($model->isNewRecord): ?>
                            <?=
                            Html::submitButton(
                                '<span class="glyphicon glyphicon-plus-sign"></span> ' . Yee::t('back', 'Create'), ['class' => 'btn btn-success']
                            )
                            ?>
                        <?php else: ?>
                            <?=
                            Html::submitButton(
                                '<span class="glyphicon glyphicon-ok"></span> ' . Yee::t('back', 'Save'), ['class' => 'btn btn-primary']
                            )
                            ?>
                        <?php endif; ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</div>
