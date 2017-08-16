<?php

namespace yeesoft\user\assets;

use yii\web\AssetBundle;

class UserAsset extends AssetBundle
{
    public $sourcePath = '@vendor/yeesoft/yii2-yee-user/assets/source';
    public $css = [
        'css/user.css',
    ];
    public $js = [
        'js/user.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}
