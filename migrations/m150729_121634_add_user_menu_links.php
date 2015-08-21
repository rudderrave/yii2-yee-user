<?php

use yii\db\Migration;
use yii\db\Schema;

class m150729_121634_add_user_menu_links extends Migration
{

    public function up()
    {

        $this->insert('menu_link', ['id' => 'user', 'menu_id' => 'admin-main-menu', 'label' => 'Users', 'image' => 'user', 'order' => 15]);

        $this->insert('menu_link', ['id' => 'user-groups', 'menu_id' => 'admin-main-menu', 'link' => '/user/permission-groups/index', 'label' => 'Permission groups', 'parent_id' => 'user', 'order' => 4]);

        $this->insert('menu_link', ['id' => 'user-log', 'menu_id' => 'admin-main-menu', 'link' => '/user/visit-log/index', 'label' => 'Visit log', 'parent_id' => 'user', 'order' => 10]);

        $this->insert('menu_link', ['id' => 'user-permission', 'menu_id' => 'admin-main-menu', 'link' => '/user/permission/index', 'label' => 'Permissions', 'parent_id' => 'user', 'order' => 3]);

        $this->insert('menu_link', ['id' => 'user-role', 'menu_id' => 'admin-main-menu', 'link' => '/user/role/index', 'label' => 'Roles', 'parent_id' => 'user', 'order' => 2]);

        $this->insert('menu_link', ['id' => 'user-user', 'menu_id' => 'admin-main-menu', 'link' => '/user/user/default/index', 'label' => 'Users', 'parent_id' => 'user', 'order' => 1]);
    }

    public function down()
    {

        $this->delete('menu_link', ['like', 'id', 'user-user']);
        $this->delete('menu_link', ['like', 'id', 'user-role']);
        $this->delete('menu_link', ['like', 'id', 'user-permission']);
        $this->delete('menu_link', ['like', 'id', 'user-log']);
        $this->delete('menu_link', ['like', 'id', 'user-groups']);
        $this->delete('menu_link', ['like', 'id', 'user']);
    }
}