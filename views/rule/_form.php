<?php

use yeesoft\helpers\Html;
use yeesoft\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yeesoft\models\AuthRule $model
 * @var yeesoft\widgets\ActiveForm $form
 */
?>

<?php $form = ActiveForm::begin(['enableClientValidation' => false]) ?>

<div class="row">
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-body">
                <?php if ($model->isNewRecord): ?>

                    <?= $form->field($model, 'className')->textInput(['maxlength' => 255, 'autofocus' => true]) ?>

                <?php else: ?>

                    <?= $form->field($model, 'name')->value() ?>
                
                    <?= $form->field($model, 'className')->value() ?>

                <?php endif; ?>
            </div>
        </div>
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
                            <?=
                            Html::a(Yii::t('yee', 'Delete'), ['delete', 'id' => $model->name], [
                                'class' => 'btn btn-default btn-block',
                                'data-pjax' => 0,
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