<?php
/**
 * @var yii\widgets\ActiveForm $form
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
use yeesoft\Yee;
use yii\helpers\ArrayHelper;

$this->title = Yee::t('back', 'Permissions for role:') . ' ' . $role->description;
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Users'), 'url' => ['/user']];
$this->params['breadcrumbs'][] = ['label' => Yee::t('back', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h2 class="lte-hide-title"><?= $this->title ?></h2>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success text-center">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

    <p>
        <?= Html::a(Yee::t('back', 'Edit'), ['update', 'id' => $role->name], ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::a(Yee::t('back', 'Create'), ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
    </p>

    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span
                            class="glyphicon glyphicon-th"></span> <?= Yee::t('back', 'Child roles') ?>
                    </strong>
                </div>
                <div class="panel-body">
                    <?= Html::beginForm(['set-child-roles', 'id' => $role->name]) ?>

                    <?= Html::checkboxList(
                        'child_roles',
                        ArrayHelper::map($childRoles, 'name', 'name'),
                        ArrayHelper::map($allRoles, 'name', 'description'),
                        [
                            'item' => function ($index, $label, $name, $checked, $value) {
                                $list = '<ul style="padding-left: 10px">';
                                foreach (Role::getPermissionsByRole($value) as $permissionName => $permissionDescription) {
                                    $list .= $permissionDescription ? "<li>{$permissionDescription}</li>" : "<li>{$permissionName}</li>";
                                }
                                $list .= '</ul>';

                                $helpIcon = Html::beginTag('span', [
                                    'title' => Yee::t('back', 'Permissions for role - "{role}"', [ 'role' => $label ]),
                                    'data-content' => $list,
                                    'data-html' => 'true',
                                    'role' => 'button',
                                    'style' => 'margin-bottom: 5px; padding: 0 5px',
                                    'class' => 'btn btn-sm btn-default role-help-btn',
                                ]);
                                $helpIcon .= '?';
                                $helpIcon .= Html::endTag('span');

                                $isChecked = $checked ? 'checked' : '';
                                $checkbox = "<label><input type='checkbox' name='{$name}' value='{$value}' {$isChecked}> {$label}</label>";

                                return $helpIcon . ' ' . $checkbox;
                            },
                            'separator' => '<br>'
                        ]
                    ) ?>

                    <hr/>
                    <?= Html::submitButton(
                        '<span class="glyphicon glyphicon-ok"></span> ' . Yee::t('back', 'Save'),
                        ['class' => 'btn btn-primary btn-sm']
                    ) ?>

                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span
                            class="glyphicon glyphicon-th"></span> <?= Yee::t('back', 'Permissions') ?>
                    </strong>
                </div>
                <div class="panel-body">
                    <?= Html::beginForm(['set-child-permissions', 'id' => $role->name]) ?>

                    <div class="row">
                        <?php foreach ($permissionsByGroup as $groupName => $permissions): ?>
                            <div class="col-sm-6">
                                <fieldset>
                                    <legend><?= $groupName ?></legend>

                                    <?= Html::checkboxList(
                                        'child_permissions',
                                        ArrayHelper::map($currentPermissions, 'name', 'name'),
                                        ArrayHelper::map($permissions, 'name', 'description'),
                                        ['separator' => '<br>']
                                    ) ?>
                                </fieldset>
                                <br/>
                            </div>


                        <?php endforeach ?>
                    </div>

                    <hr/>
                    <?= Html::submitButton(
                        '<span class="glyphicon glyphicon-ok"></span> ' . Yee::t('back', 'Save'),
                        ['class' => 'btn btn-primary btn-sm']
                    ) ?>

                    <?= Html::endForm() ?>

                </div>
            </div>
        </div>
    </div>

<?php
$this->registerJs(<<<JS

$('.role-help-btn').off('mouseover mouseleave')
	.on('mouseover', function(){
		var _t = $(this);
		_t.popover('show');
	}).on('mouseleave', function(){
		var _t = $(this);
		_t.popover('hide');
	});
JS
);
?>