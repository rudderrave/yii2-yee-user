<?php

/**
 * @var yii\widgets\ActiveForm $form
 * @var yeesoft\models\Permission $model
 */

use yeesoft\helpers\Html;
use yeesoft\models\AuthItemGroup;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

?>

<div class="permission-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'permission-form',
        'validateOnBlur' => false,
    ])
    ?>

    <div class="row">
        <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-body">

                    <?=
                    $form->field($model, 'description')->textInput(['maxlength' => 255,
                        'autofocus' => $model->isNewRecord ? true : false])
                    ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

                </div>

            </div>
        </div>

        <div class="col-md-3">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">

                        <?=
                        $form->field($model, 'group_code')
                            ->dropDownList(ArrayHelper::map(AuthItemGroup::find()->asArray()->all(),
                                'code', 'name'),
                                ['prompt' => '', 'class' => ''])
                        ?>

                        <div class="form-group">
                            <?php if ($model->isNewRecord): ?>
                                <?=
                                Html::submitButton('<span class="glyphicon glyphicon-plus-sign"></span> Create',
                                    ['class' => 'btn btn-success'])
                                ?>
                                <?=
                                Html::a('<span class="glyphicon glyphicon-remove"></span> Cancel',
                                    ['permission/'],
                                    ['class' => 'btn btn-default']
                                )
                                ?>
                            <?php else: ?>
                                <?=
                                Html::submitButton('<span class="glyphicon glyphicon-ok"></span> Save',
                                    ['class' => 'btn btn-primary'])
                                ?>
                                <?=
                                Html::a('<span class="glyphicon glyphicon-remove"></span> Delete',
                                    ['delete', 'id' => $model->name],
                                    [
                                        'class' => 'btn btn-default',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ])
                                ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
