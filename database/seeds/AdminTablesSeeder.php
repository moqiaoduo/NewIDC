<?php

use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // base tables
        Encore\Admin\Auth\Database\Menu::truncate();
        Encore\Admin\Auth\Database\Menu::insert(
            [
                [
                    "parent_id" => 0,
                    "order" => 1,
                    "title" => "Dashboard",
                    "icon" => "fa-bar-chart",
                    "uri" => "/",
                    "permission" => "dashboard"
                ],
                [
                    "parent_id" => 9,
                    "order" => 36,
                    "title" => "Admin",
                    "icon" => "fa-tv",
                    "uri" => NULL,
                    "permission" => "auth.management"
                ],
                [
                    "parent_id" => 2,
                    "order" => 37,
                    "title" => "Administrators",
                    "icon" => "fa-users",
                    "uri" => "auth/users",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 38,
                    "title" => "Roles",
                    "icon" => "fa-user",
                    "uri" => "auth/roles",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 39,
                    "title" => "Permission",
                    "icon" => "fa-ban",
                    "uri" => "auth/permissions",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 40,
                    "title" => "Menu",
                    "icon" => "fa-bars",
                    "uri" => "auth/menu",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 2,
                    "order" => 41,
                    "title" => "Operation log",
                    "icon" => "fa-history",
                    "uri" => "auth/logs",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 34,
                    "title" => "Setup",
                    "icon" => "fa-cogs",
                    "uri" => NULL,
                    "permission" => "site.config"
                ],
                [
                    "parent_id" => 0,
                    "order" => 51,
                    "title" => "File Manager",
                    "icon" => "fa-file",
                    "uri" => "media",
                    "permission" => "ext.media-manager"
                ],
                [
                    "parent_id" => 17,
                    "order" => 44,
                    "title" => "Products",
                    "icon" => "fa-shopping-cart",
                    "uri" => "/product",
                    "permission" => "product"
                ],
                [
                    "parent_id" => 17,
                    "order" => 43,
                    "title" => "Product Group",
                    "icon" => "fa-shopping-bag",
                    "uri" => "/product_group",
                    "permission" => "product"
                ],
                [
                    "parent_id" => 0,
                    "order" => 11,
                    "title" => "Services",
                    "icon" => "fa-tasks",
                    "uri" => "/service",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 17,
                    "order" => 46,
                    "title" => "Servers",
                    "icon" => "fa-server",
                    "uri" => "/server",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 17,
                    "order" => 45,
                    "title" => "Server Group",
                    "icon" => "fa-database",
                    "uri" => "/server_group",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 27,
                    "order" => 18,
                    "title" => "Support Tickets",
                    "icon" => "fa-ticket",
                    "uri" => "/ticket",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 9,
                    "order" => 42,
                    "title" => "Products/Services",
                    "icon" => "fa-shopping-basket",
                    "uri" => NULL,
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 2,
                    "title" => "Clients",
                    "icon" => "fa-users",
                    "uri" => NULL,
                    "permission" => NULL
                ],
                [
                    "parent_id" => 18,
                    "order" => 3,
                    "title" => "Users",
                    "icon" => "fa-users",
                    "uri" => "/user",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 18,
                    "order" => 4,
                    "title" => "Add User",
                    "icon" => "fa-user-plus",
                    "uri" => "/user/create",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 18,
                    "order" => 5,
                    "title" => "Manage Affiliates",
                    "icon" => "fa-user-md",
                    "uri" => "/aff",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 18,
                    "order" => 6,
                    "title" => "Mass Mail Tool",
                    "icon" => "fa-send",
                    "uri" => "/mail",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 7,
                    "title" => "Billing",
                    "icon" => "fa-bank",
                    "uri" => NULL,
                    "permission" => NULL
                ],
                [
                    "parent_id" => 23,
                    "order" => 8,
                    "title" => "Transactions",
                    "icon" => "fa-paypal",
                    "uri" => "/transaction",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 23,
                    "order" => 9,
                    "title" => "Invoices",
                    "icon" => "fa-credit-card",
                    "uri" => "/invoice",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 23,
                    "order" => 10,
                    "title" => "Gateway Log",
                    "icon" => "fa-file-text-o",
                    "uri" => "/gateway_log",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 12,
                    "title" => "Support",
                    "icon" => "fa-question-circle",
                    "uri" => NULL,
                    "permission" => NULL
                ],
                [
                    "parent_id" => 27,
                    "order" => 13,
                    "title" => "Announcements",
                    "icon" => "fa-bullhorn",
                    "uri" => "/announcement",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 27,
                    "order" => 14,
                    "title" => "Downloads",
                    "icon" => "fa-download",
                    "uri" => "/download",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 27,
                    "order" => 15,
                    "title" => "Knowledgebase",
                    "icon" => "fa-info-circle",
                    "uri" => "/knowledgebase",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 27,
                    "order" => 16,
                    "title" => "Network Issues",
                    "icon" => "fa-sitemap",
                    "uri" => "/network_issue",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 20,
                    "title" => "Reports",
                    "icon" => "fa-file-text-o",
                    "uri" => NULL,
                    "permission" => NULL
                ],
                [
                    "parent_id" => 32,
                    "order" => 21,
                    "title" => "Daily Performance",
                    "icon" => "fa-calendar",
                    "uri" => "/report/daily",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 32,
                    "order" => 22,
                    "title" => "Annual Income Report",
                    "icon" => "fa-money",
                    "uri" => "/report/income",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 32,
                    "order" => 23,
                    "title" => "New Customers",
                    "icon" => "fa-users",
                    "uri" => "/report/new_users",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 24,
                    "title" => "Utilities",
                    "icon" => "fa-magic",
                    "uri" => NULL,
                    "permission" => NULL
                ],
                [
                    "parent_id" => 36,
                    "order" => 25,
                    "title" => "To-Do List",
                    "icon" => "fa-sticky-note-o",
                    "uri" => "/todo_list",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 36,
                    "order" => 26,
                    "title" => "WHOIS Lookup",
                    "icon" => "fa-search",
                    "uri" => "/whois",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 36,
                    "order" => 27,
                    "title" => "Domain Resolver",
                    "icon" => "fa-check-circle",
                    "uri" => "/domain_resolver",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 36,
                    "order" => 28,
                    "title" => "System Status",
                    "icon" => "fa-cog",
                    "uri" => "/system_status",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 36,
                    "order" => 29,
                    "title" => "Logs",
                    "icon" => "fa-file-text-o",
                    "uri" => NULL,
                    "permission" => NULL
                ],
                [
                    "parent_id" => 41,
                    "order" => 30,
                    "title" => "Activity Log",
                    "icon" => "fa-play-circle",
                    "uri" => "/log/activity",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 41,
                    "order" => 31,
                    "title" => "Admin Log",
                    "icon" => "fa-desktop",
                    "uri" => "/log/admin_login",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 41,
                    "order" => 32,
                    "title" => "Module Log",
                    "icon" => "fa-th",
                    "uri" => "/log/module",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 41,
                    "order" => 33,
                    "title" => "Email Message Log",
                    "icon" => "fa-envelope",
                    "uri" => "/log/email",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 27,
                    "order" => 19,
                    "title" => "Open New Ticket",
                    "icon" => "fa-paper-plane-o",
                    "uri" => "/ticket/create",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 9,
                    "order" => 35,
                    "title" => "Settings",
                    "icon" => "fa-cogs",
                    "uri" => "config",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 27,
                    "order" => 17,
                    "title" => "Department",
                    "icon" => "fa-users",
                    "uri" => "/department",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 9,
                    "order" => 47,
                    "title" => "Ticket Statuses",
                    "icon" => "fa-ticket",
                    "uri" => "ticket_status",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 9,
                    "order" => 48,
                    "title" => "Email Templates",
                    "icon" => "fa-envelope",
                    "uri" => "/email_template",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 9,
                    "order" => 49,
                    "title" => "Plugins",
                    "icon" => "fa-plug",
                    "uri" => "/plugin",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 9,
                    "order" => 50,
                    "title" => "Service Statuses",
                    "icon" => "fa-tasks",
                    "uri" => "/service_status",
                    "permission" => NULL
                ]
            ]
        );

        Encore\Admin\Auth\Database\Permission::truncate();
        Encore\Admin\Auth\Database\Permission::insert(
            [
                [
                    "name" => "所有权限",
                    "slug" => "*",
                    "http_method" => "",
                    "http_path" => "*"
                ],
                [
                    "name" => "仪表盘",
                    "slug" => "dashboard",
                    "http_method" => "GET",
                    "http_path" => "/"
                ],
                [
                    "name" => "登录",
                    "slug" => "auth.login",
                    "http_method" => "",
                    "http_path" => "/auth/login\r\n/auth/logout"
                ],
                [
                    "name" => "自己的信息设定",
                    "slug" => "auth.setting",
                    "http_method" => "GET,PUT",
                    "http_path" => "/auth/setting"
                ],
                [
                    "name" => "后台管理（不含管理员列表）",
                    "slug" => "auth.management",
                    "http_method" => "",
                    "http_path" => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs"
                ],
                [
                    "name" => "网站设置",
                    "slug" => "site.config",
                    "http_method" => "",
                    "http_path" => "/config*"
                ],
                [
                    "name" => "文件管理",
                    "slug" => "ext.media-manager",
                    "http_method" => "",
                    "http_path" => "/media*"
                ],
                [
                    "name" => "产品(组)完全管理",
                    "slug" => "product",
                    "http_method" => "",
                    "http_path" => "/product*"
                ]
            ]
        );

        Encore\Admin\Auth\Database\Role::truncate();
        Encore\Admin\Auth\Database\Role::insert(
            [
                [
                    "name" => "Administrator",
                    "slug" => "administrator"
                ],
                [
                    "name" => "Web Admin",
                    "slug" => "webadmin"
                ]
            ]
        );

        // pivot tables
        DB::table('admin_role_menu')->truncate();
        DB::table('admin_role_menu')->insert(
            [

            ]
        );

        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_role_permissions')->insert(
            [
                [
                    "role_id" => 1,
                    "permission_id" => 1
                ],
                [
                    "role_id" => 2,
                    "permission_id" => 2
                ],
                [
                    "role_id" => 2,
                    "permission_id" => 3
                ],
                [
                    "role_id" => 2,
                    "permission_id" => 4
                ],
                [
                    "role_id" => 2,
                    "permission_id" => 6
                ],
                [
                    "role_id" => 2,
                    "permission_id" => 8
                ],
                [
                    "role_id" => 2,
                    "permission_id" => 9
                ]
            ]
        );

        // finish
    }
}
