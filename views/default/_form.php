<?php

use yii\jui\DatePicker;
use yeesoft\models\User;
use yeesoft\helpers\Html;
use yeesoft\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yeesoft\models\AuthRole;

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

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'username')->textInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>
                    </div>
                    <div class="col-md-6">
                        <?php if (Yii::$app->user->can('update-user-email')): ?>
                            <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($model->isNewRecord): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'first_name')->textInput(['maxlength' => 124]) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'last_name')->textInput(['maxlength' => 124]) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'gender')->dropDownList(User::getGenderList()) ?>
                    </div>
                    <div class="col-md-3">
                        <?=
                        $form->field($model, 'birthday')->widget(DatePicker::class, [
                            'options' => ['class' => 'form-control'],
                            'dateFormat' => 'yyyy-MM-dd'
                        ])
                        ?>
                    </div>
                </div>

                <?= $form->field($model, 'about')->textarea(['maxlength' => 255]) ?>
            </div>
        </div>

        <?php if (!$model->isNewRecord && Yii::$app->user->can('view-user-roles')): ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?= Yii::t('yee/user', 'Assigned Permissions') ?>
                    </h3>
                </div>
                <div class="box-body">
                    <?php foreach ($groupedPermissions as $groupName => $permissions): ?>
                        <div class="col-md-6 col-lg-4">
                            <fieldset>
                                <legend><?= $groupName ?></legend>
                                <ul>
                                    <?php foreach ($permissions as $permission): ?>
                                        <li><?= $permission->description ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </fieldset>
                            <br/>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-3">
        <?php if (!$model->isNewRecord && Yii::$app->user->can('update-user-roles')): ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?= Yii::t('yee/user', 'Roles') ?>
                    </h3>
                </div>
                <div class="box-body">
                    <?=
                    $form->field($dynamicModel, 'roles')->checkboxList(AuthRole::getRoles(), [
                        'item' => function ($index, $label, $name, $checked, $value) {

                            $help = Html::tag('span', '?', [
                                        'title' => Yii::t('yee/user', 'Click to see permissions for "{role}" role', ['role' => $label]),
                                        'style' => 'padding: 0; width: 20px; height: 20px;',
                                        'class' => 'btn btn-sm btn-default',
                            ]);

                            //$checkbox = Html::checkbox($name, $checked, ['label' => $label, 'value' => $value]); //for custom roles
                            $checkbox = Html::radio($name, $checked, ['label' => $label, 'value' => $value]); //for system roles

                            return "<div class='clearfix'><div class='pull-left' style='margin-right: 15px;'>{$checkbox}</div><div>{$help}</div></div>";
                        }
                    ])->label(false)
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="box box-primary">
            <div class="box-body">   
                <?= $form->field($model->loadDefaultValues(), 'status')->dropDownList(User::getStatusList()) ?>

                <?php if (Yii::$app->user->can('update-user-email')): ?>
                    <?= $form->field($model, 'email_confirmed')->checkbox() ?>
                <?php endif; ?>

                <?= $form->field($model, 'skype')->textInput(['maxlength' => 64]) ?>

                <?= $form->field($model, 'phone')->textInput(['maxlength' => 24]) ?>

                <?php if (Yii::$app->user->can('bind-user-to-ip')): ?>
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