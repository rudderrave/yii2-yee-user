<?php

/**
 * @var yeesoft\widgets\ActiveForm $form
 * @var array $childRoles
 * @var array $allRoles
 * @var array $routes
 * @var array $currentRoutes
 * @var array $permissionsByGroup
 * @var array $currentPermissions
 * @var yii\rbac\Role $role
 */
use yeesoft\helpers\Html;
use yeesoft\models\Role;
use yeesoft\models\User;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('yee/user', '{permission} Role Settings', ['permission' => $role->description]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Roles'), 'url' => ['/user/role/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['header-content'] = Html::a(Yii::t('yee', 'Edit'), ['update', 'id' => $role->name], ['class' => 'btn btn-sm btn-primary'])
        . ' ' . Html::a(Yii::t('yee', 'Add New'), ['create'], ['class' => 'btn btn-sm btn-primary']);
?>

<div class="row">
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <?= Yii::t('yee/user', 'Child roles') ?>
                </h3>
            </div>
            <div class="box-body">
                <?= Html::beginForm(['set-child-roles', 'id' => $role->name]) ?>
                <?=
                Html::checkboxList('child_roles', ArrayHelper::map($childRoles, 'name', 'name'), ArrayHelper::map($allRoles, 'name', 'description'), [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $list = '<ul style="padding-left: 10px">';
                        foreach (Role::getPermissionsByRole($value) as $permissionName => $permissionDescription) {
                            $list .= $permissionDescription ? "<li>{$permissionDescription}</li>" : "<li>{$permissionName}</li>";
                        }
                        $list .= '</ul>';

                        $helpIcon = Html::beginTag('span', [
                                    'title' => Yii::t('yee/user', 'Permissions for "{role}" role', ['role' => $label]),
                                    'data-content' => $list,
                                    'data-html' => 'true',
                                    'role' => 'button',
                                    'style' => 'margin-bottom: 5px; padding: 0 5px',
                                    'class' => 'btn btn-sm btn-default role-help-btn',
                        ]);
                        $helpIcon .= '?';
                        $helpIcon .= Html::endTag('span');

                        $checkbox = Html::checkbox($name, $checked, ['label' => $label, 'value' => $value]);
                        return "<div><div class='pull-left' style='margin-right: 15px;'>{$checkbox}</div><div>{$helpIcon}</div></div>";
                    },
                        //'separator' => '<br>'
                        ]
                )
                ?>

                <hr/>
                <?php if (User::hasPermission('manageRolesAndPermissions')): ?>
                    <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary btn-sm']) ?>
                <?php endif; ?>

                <?= Html::endForm() ?>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <?= Yii::t('yee/user', 'Active Filters') ?>
                </h3>
            </div>
            <div class="box-body">
                <?= Html::beginForm(['set-active-filters', 'id' => $role->name]) ?>
                <?=
                Html::checkboxList('filters', ArrayHelper::getColumn($selecedActiveFilters, 'id'), ArrayHelper::map($activeFilters, 'id', 'name'), [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        return Html::checkbox($name, $checked, ['label' => $label, 'value' => $value]);
                    }
                ])
                ?>
                <hr/>
                <?php if (User::hasPermission('manageRolesAndPermissions')): ?>
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
                    <?= Yii::t('yee/user', 'Permissions') ?>
                </h3>
            </div>
            <div class="box-body">
                <?= Html::beginForm(['set-child-permissions', 'id' => $role->name]) ?>
                <div class="row">
                    <?php foreach ($permissionsByGroup as $groupName => $permissions): ?>
                        <div class="col-sm-6">
                            <fieldset>
                                <legend><?= $groupName ?></legend>
                                <?=
                                Html::checkboxList(
                                        'child_permissions', ArrayHelper::map($currentPermissions, 'name', 'name'), ArrayHelper::map($permissions, 'name', 'description')
                                )
                                ?>
                            </fieldset>
                            <br/>
                        </div>
                    <?php endforeach ?>
                </div>

                <hr/>

                <?php if (User::hasPermission('manageRolesAndPermissions')): ?>
                    <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary btn-sm']) ?>
                <?php endif; ?>

                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>

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