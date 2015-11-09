<?php

namespace yeesoft\user;

use Yii;

class UserModule extends \yii\base\Module
{
    /**
     * Controller namespace
     *
     * @var string
     */
    public $controllerNamespace = 'yeesoft\user\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['yii2-yee-user/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/yeesoft/yii2-yee-user/messages',
            'fileMap' => [
                'yii2-yee-user/user' => 'user.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('yii2-yee-user/' . $category, $message, $params, $language);
    }
}