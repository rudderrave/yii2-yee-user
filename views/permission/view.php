<?php

/**
 * @var $this yii\web\View
 * @var yeesoft\widgets\ActiveForm $form
 * @var array $routes
 * @var array $selectedRoutes
 * @var array $permissions
 * @var array $selectedPermissions
 * @var yii\rbac\Permission $item
 */
use yii\helpers\ArrayHelper;
use yeesoft\helpers\Html;
use yeesoft\models\User;
use yeesoft\user\assets\UserAsset;

UserAsset::register($this);

$this->title = Yii::t('yee/user', '{permission} Permission Settings', ['permission' => $item->description]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['header-content'] = Html::a(Yii::t('yee', 'Edit'), ['update', 'id' => $item->name], ['class' => 'btn btn-sm btn-primary'])
        . ' ' . Html::a(Yii::t('yee', 'Add New'), ['create'], ['class' => 'btn btn-sm btn-primary']);
?>

<div class="row">
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <?= Yii::t('yee/user', 'Child permissions') ?>
                </h3>
            </div>
            <div class="box-body">
                <?= Html::beginForm(['set-permissions', 'id' => $item->name]) ?>

                <div class="row">
                    <?php foreach ($permissions as $group => $permissions): ?>
                        <div class="col-sm-12">
                            <fieldset>
                                <legend><?= $group ?></legend>
                                <?= Html::checkboxList('child_permissions', ArrayHelper::map($selectedPermissions, 'name', 'name'), ArrayHelper::map($permissions, 'name', 'description')) ?>
                            </fieldset>
                            <hr/>
                        </div>
                    <?php endforeach ?>
                </div>

                <hr/>
                <?php if (Yii::$app->user->can('manage-roles-and-permissions')): ?>
                    <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary btn-sm']) ?>
                <?php endif; ?>

                <?= Html::endForm() ?>
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
                <?= Html::beginForm(['set-routes', 'id' => $item->name]) ?>

                <div class="row">
                    <div class="col-sm-3">
                        <?php if (Yii::$app->user->can('manage-roles-and-permissions')): ?>
                            <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary btn-sm']) ?>
                        <?php endif; ?>
                    </div>
                </div>

                <hr/>

                <?=
                Html::checkboxList('child_routes', $selectedRoutes, $routes, [
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
                ])
                ?>

                <hr/>
                <?php if (Yii::$app->user->can('manage-roles-and-permissions')): ?>
                    <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary btn-sm']) ?>
                <?php endif; ?>

                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>