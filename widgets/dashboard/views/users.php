<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
?>

<div class="pull-<?= $position ?> col-lg-<?= $width ?> widget-height-<?= $height ?>">
    <div class="panel panel-default" style="position:relative; padding-bottom:15px;">
        <div class="panel-heading">Users</div>
        <div class="panel-body">

            <h4 style="font-style: italic;">Recently Registered:</h4>

            <div class="clearfix">
                <?php foreach ($recent as $item) : ?>
                    <div class="clearfix" style="border-bottom: 1px solid #eee; margin: 7px; padding: 0 0 5px 5px;">
                        <span style="font-size:80%; margin-right: 10px;"
                              class="label label-primary">[<?= $item->createdDateTime ?>]</span>
                        <?= $item->username ?> -  <?= $item->email ?> -  <?= $item->registration_ip ?>
                    </div>
                <?php endforeach; ?>

            </div>

            <div style=" position: absolute; bottom:10px; left:0; right:0; text-align: center;"> |
                <?php foreach ($users as $item) : ?>
                    <?= Html::a('<b>' . $item['count'] . '</b> ' . $item['label'], $item['url']); ?> &nbsp; | &nbsp;
                <?php endforeach; ?>
            </div>


        </div>
    </div>
</div>