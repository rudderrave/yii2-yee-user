<?php

use yeesoft\helpers\Html;
use yeesoft\models\User;
use yeesoft\widgets\ActiveForm;
use yeesoft\helpers\YeeHelper;

/**
 * @var yii\web\View $this
 * @var yeesoft\models\User $model
 * @var yeesoft\widgets\ActiveForm $form
 */
?>

<?php $form = ActiveForm::begin() ?>

<div class="row">
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-body">
                <?= $form->field($model, 'username')->textInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>

                <?php if ($model->isNewRecord): ?>
                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>
                    <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>
                <?php endif; ?>

                <?php if (User::hasPermission('editUserEmail')): ?>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'first_name')->textInput(['maxlength' => 124]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'last_name')->textInput(['maxlength' => 124]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($model, 'gender')->dropDownList(User::getGenderList()) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'birth_day')->textInput(['maxlength' => 2]) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'birth_month')->dropDownList(YeeHelper::getMonthsList()) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'birth_year')->textInput(['maxlength' => 4]) ?>
                    </div>
                </div>

                <?= $form->field($model, 'info')->textarea(['maxlength' => 255]) ?>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body">   

                <?= $form->field($model->loadDefaultValues(), 'status')->dropDownList(User::getStatusList()) ?>

                <?php if (User::hasPermission('editUserEmail')): ?>
                    <?= $form->field($model, 'email_confirmed')->checkbox() ?>
                <?php endif; ?>

                <?= $form->field($model, 'skype')->textInput(['maxlength' => 64]) ?>

                <?= $form->field($model, 'phone')->textInput(['maxlength' => 24]) ?>

                <?php if (User::hasPermission('bindUserToIp')): ?>
                    <?= $form->field($model, 'bind_to_ip')->textInput(['maxlength' => 255])->hint(Yii::t('yee', 'For example') . ' : 123.34.56.78, 234.123.89.78') ?>
                <?php endif; ?>

            </div>
        </div>


        <div class="box box-primary">
            <div class="box-body">

                <?= $form->field($model, 'registration_ip')->value() ?>

                <?= $form->field($model, 'createdDatetime')->value() ?>

                <?= $form->field($model, 'updatedDatetime')->value() ?>

                <div class="row">
                    <?php if ($model->isNewRecord): ?>
                        <div class="col-md-6">
                            <?= Html::submitButton(Yii::t('yee', 'Create'), ['class' => 'btn btn-primary btn-block']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= Html::a(Yii::t('yee', 'Cancel'), ['index'], ['class' => 'btn btn-default btn-block']) ?>
                        </div>
                    <?php else: ?>
                        <div class="col-md-6">
                            <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary btn-block']) ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                            Html::a(Yii::t('yee', 'Delete'), ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-default btn-block',
                                'data' => [
                                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ])
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>