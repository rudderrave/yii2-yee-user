<?php

use yeesoft\usermanagement\components\GhostHtml;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yeesoft\usermanagement\models\AuthItemGroup $model
 * @var yii\bootstrap\ActiveForm $form
 */
?>

<div class="permission-groups-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'permission-groups-form',
        'validateOnBlur' => false,
    ])
    ?>

    <div class="row">
        <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-body">

                    <?=
                    $form->field($model, 'name')->textInput(['maxlength' => 255,
                        'autofocus' => $model->isNewRecord ? true : false])
                    ?>

                    <?= $form->field($model, 'code')->textInput(['maxlength' => 64]) ?>

                </div>

            </div>
        </div>

        <div class="col-md-3">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">


                        <div class="form-group">
                            <?php if ($model->isNewRecord): ?>
                                <?=
                                GhostHtml::submitButton('<span class="glyphicon glyphicon-plus-sign"></span> Create',
                                    ['class' => 'btn btn-success'])
                                ?>
                                <?=
                                GhostHtml::a('<span class="glyphicon glyphicon-remove"></span> Cancel',
                                    ['permission-groups/'],
                                    ['class' => 'btn btn-default']
                                )
                                ?>
                            <?php else: ?>
                                <?=
                                GhostHtml::submitButton('<span class="glyphicon glyphicon-ok"></span> Save',
                                    ['class' => 'btn btn-primary'])
                                ?>
                                <?=
                                GhostHtml::a('<span class="glyphicon glyphicon-remove"></span> Delete',
                                    ['delete', 'id' => $model->code],
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






