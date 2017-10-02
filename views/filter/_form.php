<?php

use yeesoft\helpers\Html;
use yii\helpers\ArrayHelper;
use yeesoft\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yeesoft\models\AuthFilter $model
 * @var yeesoft\widgets\ActiveForm $form
 */
?>

<?php $form = ActiveForm::begin() ?>

<div class="row">
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-body">
                <?= $form->field($model, 'title')->textInput(['maxlength' => 64, 'autofocus' => $model->isNewRecord ? true : false]) ?>

                <?= $form->field($model, 'name')->slugInput(['maxlength' => 64], 'title') ?>
                
                <?= $form->field($model, 'class_name')->textInput(['maxlength' => 255]) ?>
            </div>
        </div>

        <?php if (!$model->isNewRecord): ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?= Yii::t('yee/user', 'Apply to Models') ?>
                    </h3>
                </div>
                <div class="box-body">
                    <?=
                    Html::checkboxList('models', ArrayHelper::getColumn($selected, 'name'), ArrayHelper::map($models, 'name', 'class_name'), [
                        'item' => function ($index, $label, $name, $checked, $value) {
                            return Html::checkbox($name, $checked, ['label' => $label, 'value' => $value]);
                        }
                    ])
                    ?>
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