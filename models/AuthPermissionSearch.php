<?php

namespace yeesoft\user\models;

class AuthPermissionSearch extends AuthItemSearch
{

    const ITEM_TYPE = self::TYPE_PERMISSION;

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }

}
