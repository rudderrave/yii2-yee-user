<?php

namespace yeesoft\user\models;

class AuthRoleSearch extends AuthItemSearch
{

    const ITEM_TYPE = self::TYPE_ROLE;

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }

}
