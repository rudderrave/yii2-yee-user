<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
?>

    <div class="pull-<?= $position ?> col-lg-<?= $width ?> widget-height-<?= $height ?>">
        <div class="panel panel-default dw-widget">
            <div class="panel-heading"><?= Yii::t('yee/user', 'Users') ?></div>
            <div class="panel-body">

                <?php if (count($recent)): ?>
                    <div class="clearfix">
                        <?php foreach ($recent as $item) : ?>
                            <div class="clearfix dw-user">
                                <div class="avatar">
                                    <img src="<?= ($item->avatar) ?>"/>
                                </div>

                                <div class="dw-user-info">
                                    <div>
                                        <b><?= Yii::t('yee', 'Login') ?>:</b>
                                        <a class="author"><?= $item->username ?></a>
                                    </div>
                                    <div>
                                        <b><?= Yii::t('yee', 'E-mail') ?>:</b>
                                        <span><?= $item->email ?></span>
                                    </div>
                                    <div>
                                        <b><?= Yii::t('yee', 'Data') ?>:</b>
                                        <span><?= "{$item->createdDate} {$item->createdTime}" ?></span>
                                    </div>
                                    <div>
                                        <b><?= Yii::t('yee', 'Registration IP') ?>:</b>
                                        <span><?= $item->registration_ip ?></span>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>

                    <div class="dw-quick-links">
                        <?php $list = [] ?>
                        <?php foreach ($users as $item) : ?>
                            <?php $list[] = Html::a("<b>{$item['count']}</b> {$item['label']}", $item['url']); ?>
                        <?php endforeach; ?>
                        <?= implode(' | ', $list) ?>
                    </div>

                <?php else: ?>
                    <h4><em><?= Yii::t('yee/user', 'No users found.') ?></em></h4>
                <?php endif; ?>

            </div>
        </div>
    </div>
<?php
$css = <<<CSS
.dw-widget{
    position:relative;
    padding-bottom:15px;
}
.dw-user {
    border-bottom: 1px solid #eee;
    padding-bottom: 5px;
    margin-bottom: 5px;
}
.dw-user-info {
    padding-left: 60px;
}
.dw-quick-links{
    position: absolute;
    bottom:10px;
    left:0;
    right:0;
    text-align: center;
}
.avatar {
    float: left;
    margin-right: 10px;
    margin-top: 3px;
}

CSS;

$this->registerCss($css);
?>