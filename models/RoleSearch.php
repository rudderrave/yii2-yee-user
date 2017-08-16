<?php

namespace yeesoft\user\models;

class RoleSearch extends AbstractItemSearch
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
