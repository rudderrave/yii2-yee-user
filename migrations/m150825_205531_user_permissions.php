<?php

use yeesoft\db\PermissionsMigration;

class m150825_205531_user_permissions extends PermissionsMigration
{

    public function safeUp()
    {
        $this->addPermissionsGroup('user-management', 'User Management');

        parent::safeUp();
    }

    public function safeDown()
    {
        parent::safeDown();
        $this->deletePermissionsGroup('user-management');
    }

    public function getPermissions()
    {
        return [
            'user-management' => [
                'view-users' => [
                    'title' => 'View Users',
                    'roles' => [self::ROLE_MODERATOR],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/default', 'action' => 'index'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/default', 'action' => 'view'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/default', 'action' => 'grid-sort'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/default', 'action' => 'grid-page-size'],
                    ],
                ],
                'update-users' => [
                    'title' => 'Update Users',
                    'child' => ['view-users'],
                    'roles' => [self::ROLE_ADMIN],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/default', 'action' => 'update'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/default', 'action' => 'bulk-activate'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/default', 'action' => 'bulk-deactivate'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/default', 'action' => 'toggle-attribute'],
                    ],
                ],
                'create-users' => [
                    'title' => 'Create Users',
                    'child' => ['view-users'],
                    'roles' => [self::ROLE_ADMIN],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/default', 'action' => 'create'],
                    ],
                ],
                'delete-users' => [
                    'title' => 'Delete Users',
                    'child' => ['view-users'],
                    'roles' => [self::ROLE_ADMIN],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/default', 'action' => 'delete'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/default', 'action' => 'bulk-delete'],
                    ],
                ],
                'update-user-password' => [
                    'title' => 'Update User Password',
                    'child' => ['view-users'],
                    'roles' => [self::ROLE_ADMIN],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/default', 'action' => 'change-password'],
                    ],
                ],
                //
                'view-roles-and-permissions' => [
                    'title' => 'View Roles And Permissions',
                    'child' => ['view-users'],
                    'roles' => [self::ROLE_ADMIN],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/groups', 'action' => 'index'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/permission', 'action' => 'index'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/role', 'action' => 'index'],
                    ],
                ],
                'manage-roles-and-permissions' => [
                    'title' => 'Manage Roles And Permissions',
                    'child' => ['view-users'],
                    'roles' => [self::ROLE_ADMIN],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/groups', 'action' => 'update'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/groups', 'action' => 'create'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/groups', 'action' => 'delete'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/permission', 'action' => 'update'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/permission', 'action' => 'create'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/permission', 'action' => 'delete'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/role', 'action' => 'update'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/role', 'action' => 'create'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/role', 'action' => 'delete'],
                    ],
                ],
                'view-logs' => [
                    'title' => 'View User Logs',
                    'roles' => [self::ROLE_ADMIN],
                    'routes' => [
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/logs', 'action' => 'index'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/logs', 'action' => 'view'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/logs', 'action' => 'grid-sort'],
                        ['bundle' => self::ADMIN_BUNDLE, 'controller' => 'user/logs', 'action' => 'grid-page-size'],
                    ],
                ],
                'bind-user-to-ip' => [
                    'title' => 'Bind User To IP',
                    'roles' => [self::ROLE_ADMIN],
                ],
                'view-user-email' => [
                    'title' => 'Bind User To IP',
                    'roles' => [self::ROLE_MODERATOR],
                ],
                'update-user-email' => [
                    'title' => 'Bind User To IP',
                    'child' => ['view-user-email'],
                    'roles' => [self::ROLE_ADMIN],
                ],
                'view-user-ip' => [
                    'title' => 'View User IP',
                    'roles' => [self::ROLE_ADMIN],
                ],
                'view-user-roles' => [
                    'title' => 'View User Roles',
                    'roles' => [self::ROLE_ADMIN],
                ],
            ],
        ];
    }

}
