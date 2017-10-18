<?php

/**
 * @var yeesoft\widgets\ActiveForm $form
 * @var yeesoft\models\AuthPermission $model
 */
use yeesoft\helpers\Html;
use yeesoft\models\AuthRule;
use yeesoft\models\AuthGroup;
use yeesoft\models\AuthRoute;
use yeesoft\models\AuthPermission;
use yeesoft\widgets\ActiveForm;
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
                            <?= Html::hiddenInput('DynamicModel[childPermissions]') ?>
                            <?php $permissions = AuthPermission::getGroupedPermissions([$model->name]); ?>
                            <?php foreach ($permissions as $group => $list): ?>
                                <?= $form->field($dynamicModel, 'childPermissions')->checkboxList($list, ['unselect' => null])->label($group); ?>
                            <?php endforeach ?>
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
                            <?= $form->field($dynamicModel, 'permissionRoutes')->checkboxList(AuthRoute::getRoutes())->label(false) ?>
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

                <?= $form->field($model, 'groupName')->dropDownList(AuthGroup::getGroups()) ?>

                <?= $form->field($model, 'rule_name')->dropDownList(AuthRule::getRules(), ['prompt' => '']) ?>

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