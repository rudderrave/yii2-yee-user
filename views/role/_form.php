<?php

/**
 * @var yeesoft\widgets\ActiveForm $form
 * @var yeesoft\models\AuthRole $model
 */
use yeesoft\helpers\Html;
use yeesoft\widgets\ActiveForm;
use yeesoft\models\AuthRole;
use yeesoft\models\User;
use yeesoft\models\AuthFilter;
use yii\helpers\ArrayHelper;
use yeesoft\models\AuthPermission;
?>

<?php
$this->registerJs(<<<JS

$('.role-help-btn').off('mouseover mouseleave')
    .on('mouseover', function(){
        $(this).popover('show');
    }).on('mouseleave', function(){
        $(this).popover('hide');
    });
JS
);
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
                                <?= Yii::t('yee/user', 'Child roles') ?>
                            </h3>
                        </div>
                        <div class="box-body">
                            <?= $form->field($dynamicModel, 'roles')->checkboxList(AuthRole::getRoles($model->name))->label(false) ?>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <?= Yii::t('yee/user', 'Active Filters') ?>
                            </h3>
                        </div>
                        <div class="box-body">
                            <?= $form->field($dynamicModel, 'filters')->checkboxList(AuthFilter::getFilters())->label(false) ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <?= Yii::t('yee/user', 'Permissions') ?>
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <?= Html::hiddenInput('DynamicModel[permissions]') ?>
                                <?php $permissions = AuthPermission::getGroupedPermissions(); ?>
                                <?php foreach ($permissions as $group => $list): ?>
                                    <div class="col-md-4">
                                        <?= $form->field($dynamicModel, 'permissions')->checkboxList($list, ['unselect' => null])->label($group); ?>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>


    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <?php if ($model->isNewRecord): ?>
                        <div class="col-md-6">
                            <?= Html::submitButton(Yii::t('yee', 'Create'), ['class' => 'btn btn-primary btn-block']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= Html::a(Yii::t('yee', 'Cancel'), ['index'], ['class' => 'btn btn-default btn-block']) ?>
                        </div>
                    <?php else: ?>
                        <div class="col-md-12">
                            <?= $form->field($model, 'name')->value() ?>
                        </div>
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