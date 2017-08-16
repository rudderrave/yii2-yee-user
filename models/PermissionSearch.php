<?php

namespace yeesoft\user\models;

class PermissionSearch extends AbstractItemSearch
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
