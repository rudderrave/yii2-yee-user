<?php

/**
 * @var yii\web\View $this
 * @var array $permissionsByGroup
 * @var yeesoft\models\User $user
 */
use yeesoft\models\AuthRole;
use yii\helpers\ArrayHelper;
use yeesoft\helpers\Html;

$this->title = Yii::t('yee/user', 'Roles and Permissions for "{user}"', ['user' => $user->username]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', $user->username), 'url' => ['default/update', 'id' => $user->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <?= Yii::t('yee/user', 'Roles') ?>
                </h3>
            </div>
            <div class="box-body">
                <?= Html::beginForm(['roles', 'id' => $user->id]) ?>

                <?=
                Html::checkboxList('roles', ArrayHelper::map(AuthRole::getUserRoles($user->id), 'name', 'name'), ArrayHelper::map(AuthRole::getAvailableRoles(), 'name', 'description'), [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $list = '<ul style="padding-left: 10px">';
                        foreach (AuthRole::getPermissionsByRole($value) as $permissionName => $permissionDescription) {
                            $list .= $permissionDescription ? "<li>{$permissionDescription}</li>" : "<li>{$permissionName}</li>";
                        }
                        $list .= '</ul>';

                        $helpIcon = Html::beginTag('span', [
                                    'title' => Yii::t('yee/user', 'Permissions for "{role}" role', ['role' => $label]),
                                    'data-content' => $list,
                                    'data-html' => 'true',
                                    'role' => 'button',
                                    'style' => 'margin: 0 30px 5px 0; padding: 0 5px;',
                                    'class' => 'btn btn-sm btn-default role-help-btn',
                        ]);
                        $helpIcon .= '?';
                        $helpIcon .= Html::endTag('span');

                        $checkbox = Html::checkbox($name, $checked, ['label' => $label, 'value' => $value]);
                        return "<div><div class='pull-left' style='margin-right: 15px;'>{$checkbox}</div><div>{$helpIcon}</div></div>";
                    },
                        ]
                )
                ?>
                <hr/>

                <?php if (Yii::$app->user->isSuperadmin OR Yii::$app->user->id != $user->id): ?>
                    <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary btn-sm']) ?>
                <?php else: ?>
                    <div class="alert alert-warning well-sm text-center">
                        <?= Yii::t('yee/user', "You can't update own permissions!") ?>
                    </div>
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
                <?php foreach ($permissionsByGroup as $groupName => $permissions): ?>
                    <div class="col-sm-6">
                        <fieldset>
                            <legend><?= $groupName ?></legend>
                            <ul>
                                <?php foreach ($permissions as $permission): ?>
                                    <li><?= $permission->description ?></li>
                                <?php endforeach ?>
                            </ul>
                        </fieldset>
                        <br/>
                    </div>
                <?php endforeach ?>
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