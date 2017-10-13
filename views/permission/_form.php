<?php

/**
 * @var yeesoft\widgets\ActiveForm $form
 * @var yeesoft\models\AuthPermission $model
 */
use yeesoft\helpers\Html;
use yeesoft\models\AuthGroup;
use yii\helpers\ArrayHelper;
use yeesoft\widgets\ActiveForm;
use yeesoft\models\AuthRule;
use yeesoft\models\User;
use yeesoft\user\assets\UserAsset;
?>

<?php $form = ActiveForm::begin() ?>

<div class="row">
    <div class="col-md-9">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <?= $form->field($model, 'description')->textInput(['maxlength' => 255, 'autofocus' => $model->isNewRecord ? true : false]) ?>

                        <?php if ($model->isNewRecord): ?>
                            <?= $form->field($model, 'name')->slugInput(['maxlength' => 64], 'description') ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!$model->isNewRecord): ?>


            <div class="row">
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <?= Yii::t('yee/user', 'Child permissions') ?>
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <?php foreach ($permissions as $group => $permissions): ?>
                                    <div class="col-sm-12">
                                        <fieldset>
                                            <legend><?= $group ?></legend>
                                            <?= $form->field($dynamicModel, 'childPermissions')->checkboxList(ArrayHelper::map($permissions, 'name', 'description')); ?>
                                        </fieldset>
                                        <hr/>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <?= Yii::t('yee/user', 'Routes') ?>
                            </h3>
                        </div>
                        <div class="box-body">
                            <?=
                            $form->field($dynamicModel, 'permissionRoutes')->checkboxList($routes, [
                                'id' => 'routes-list',
                                'separator' => '<div class="separator"></div>',
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    return Html::checkbox($name, $checked, [
                                                'value' => $value,
                                                'label' => '<span class="route-text">' . $label . '</span>',
                                                'labelOptions' => ['class' => 'route-label'],
                                                'class' => 'route-checkbox',
                                    ]);
                                },
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

<?php endif; ?>


    </div>

    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body">
                <?php if (!$model->isNewRecord): ?>
                    <?= $form->field($model, 'name')->value() ?>
                <?php endif; ?>

                <?= $form->field($model, 'groupName')->dropDownList(ArrayHelper::map(AuthGroup::find()->asArray()->all(), 'name', 'title')) ?>

<?= $form->field($model, 'rule_name')->dropDownList(ArrayHelper::map(AuthRule::find()->asArray()->all(), 'name', 'name'), ['prompt' => '']) ?>

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
                            Html::a(Yii::t('yee', 'Delete'), ['delete', 'id' => $model->name], [
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