# yii2-yee-user

##Yee CMS - User Module use in Yee-Core-Rest

####Backend module for managing users, roles, permissions, etc. 

This module is part of Yee CMS (based on Yii2 Framework).

Installation
------------

Either run

```
composer require --prefer-dist rudderrave/yii2-yee-user "dev-master"
```

or add

```
"rudderrave/yii2-yee-user": "dev-master"
```

to the require section of your `composer.json` file.

Run migrations:

```php
yii migrate --migrationPath=@vendor/rudderrave/yii2-yee-user/migrations/
```

Configuration
------
- In your backend config file

```php
'modules'=>[
    'user' => [
        'class' => 'yeesoft\user\UserModule',
    ],
],
```

Dashboard widget
-------  

You can use dashboard widget to display short information about users.

Add this code in your control panel dashboard to display widget:
```php
echo \yeesoft\user\widgets\dashboard\Users::widget();
```
