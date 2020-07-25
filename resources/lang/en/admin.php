<?php

return [
    'online'                => 'Online',
    'login'                 => 'Login',
    'logout'                => 'Logout',
    'setting'               => 'Setting',
    'name'                  => 'Name',
    'username'              => 'Username',
    'password'              => 'Password',
    'password_confirmation' => 'Password confirmation',
    'remember_me'           => 'Remember me',
    'user_setting'          => 'User setting',
    'avatar'                => 'Avatar',
    'list'                  => 'List',
    'new'                   => 'New',
    'create'                => 'Create',
    'delete'                => 'Delete',
    'remove'                => 'Remove',
    'edit'                  => 'Edit',
    'view'                  => 'View',
    'continue_editing'      => 'Continue editing',
    'continue_creating'     => 'Continue creating',
    'detail'                => 'Detail',
    'browse'                => 'Browse',
    'reset'                 => 'Reset',
    'export'                => 'Export',
    'batch_delete'          => 'Batch delete',
    'save'                  => 'Save',
    'refresh'               => 'Refresh',
    'order'                 => 'Order',
    'expand'                => 'Expand',
    'collapse'              => 'Collapse',
    'filter'                => 'Filter',
    'search'                => 'Search',
    'close'                 => 'Close',
    'show'                  => 'Show',
    'entries'               => 'entries',
    'captcha'               => 'Captcha',
    'action'                => 'Action',
    'title'                 => 'Title',
    'description'           => 'Description',
    'back'                  => 'Back',
    'back_to_list'          => 'Back to List',
    'submit'                => 'Submit',
    'menu'                  => 'Menu',
    'input'                 => 'Input',
    'succeeded'             => 'Succeeded',
    'failed'                => 'Failed',
    'delete_confirm'        => 'Are you sure to delete this item ?',
    'delete_succeeded'      => 'Delete succeeded !',
    'delete_failed'         => 'Delete failed !',
    'update_succeeded'      => 'Update succeeded !',
    'save_succeeded'        => 'Save succeeded !',
    'refresh_succeeded'     => 'Refresh succeeded !',
    'login_successful'      => 'Login successful',
    'choose'                => 'Choose',
    'choose_file'           => 'Select file',
    'choose_image'          => 'Select image',
    'more'                  => 'More',
    'deny'                  => 'Permission denied',
    'administrator'         => 'Administrator',
    'roles'                 => 'Roles',
    'permissions'           => 'Permissions',
    'slug'                  => 'Slug',
    'created_at'            => 'Created At',
    'updated_at'            => 'Updated At',
    'alert'                 => 'Alert',
    'parent_id'             => 'Parent',
    'icon'                  => 'Icon',
    'uri'                   => 'URI',
    'operation_log'         => 'Operation log',
    'parent_select_error'   => 'Parent select error',
    'pagination'            => [
        'range' => 'Showing :first to :last of :total entries',
    ],
    'role'                  => 'Role',
    'permission'            => 'Permission',
    'route'                 => 'Route',
    'confirm'               => 'Confirm',
    'cancel'                => 'Cancel',
    'http'                  => [
        'method' => 'HTTP method',
        'path'   => 'HTTP path',
    ],
    'all_methods_if_empty'  => 'All methods if empty',
    'all'                   => 'All',
    'current_page'          => 'Current page',
    'selected_rows'         => 'Selected rows',
    'upload'                => 'Upload',
    'new_folder'            => 'New folder',
    'time'                  => 'Time',
    'size'                  => 'Size',
    'listbox'               => [
        'text_total'         => 'Showing all {0}',
        'text_empty'         => 'Empty list',
        'filtered'           => '{0} / {1}',
        'filter_clear'       => 'Show all',
        'filter_placeholder' => 'Filter',
    ],
    'grid_items_selected'    => '{n} items selected',

    'menu_titles'            => [],
    'prev'                   => 'Prev',
    'next'                   => 'Next',
    'quick_create'           => 'Quick create',
    'help'                      => [
        'product'               => [
            'free_domain'       => 'Input the free domain you provide to users without a dot prefix.
                                    The comma or enter end input.',
            'require_domain'    => 'The user is required to enter a valid domain name when ordering.',
            'ena_stock'         => 'When enabled, the number of purchases of this product will be limited.',
            'unlimited_when_buy'=> 'When enabled, users can select a permanent period when they purchase,
                                    otherwise they can only select when they renew.',
            'price_name'        => 'Use candidate If you want localization. e.g. $monthly',
            'price'             => 'If FREE, set 0 in the field.',
            'description'       => 'You may use HTML in this field<br>
&lt;br&gt; New line
&lt;b&gt;Bold&lt;/b&gt; <b>Bold</b>
&lt;i&gt;Italics&lt;/i&gt; <i>Italics</i>',
            'free_limit_days'   => 'If FREE were selected by users, they should not renew until the setting day.<br>
P.S. If you want unlimited, set 0',
            'free_limit'        => 'Allow number of orders in every user',
        ],
        'config'            => [
            'tos'           => 'If enable, clients must agree to your Terms of Service.',
            'sug'           => 'If "Random username" is selected, a random username will be generated;
            If "Generate from domain" is selected, all letters in the domain name will be taken.',
            'site_suu'      => 'When enabled, services with the same username in the whole website are not allowed.',
            'site_sdu'      => 'When enabled, services with the same domain in the whole website are not allowed.',
            'admin_email'   => 'The default sender address used for emails sent by NewIDC',
            'template'      => 'You can click the cross symbol on the right side to use default template.',
            'tpl_settings'  => 'Template Settings (Need to save first)',
            'tpl_hp'        => 'You can show 4 products at most at the homepage.',
            'url'           => 'It is very important for Cron. Please make sure the System URL is right.',
            'suspend_days'              => 'Enter the number of days after the due payment date you want to wait before suspending the account',
            'termination_days'          => 'Enter the number of days after the due payment date you want to wait before terminating the account',
            'send_suspension_email'     => 'Send the Service Suspension Notification email on successful Suspend.',
            'send_unsuspension_email'   => 'Send the Service Unsuspension Notification email on successful Unsuspend.',
            'unsuspension'              => 'Enable automatic unsuspension on payment',
            'limit_activity_log'        => 'The maximum number of System Level Activity Log entries you wish to retain'
        ],
        'server'                    => [
            'access_hash'           => 'Some servers may need to provide Access Key / Hash to access the API.',
            'max_load'              => 'This value is the maximum number of services hosted by the server.'.
                'When the load is full, the server will not be allowed to join the service. 0 means infinite.',
            'status_address'        => 'To display this server on the server status page, enter the full path to the'.
            'server status folder (required to be uploaded to each server you want to monitor)'.
            '- eg. https://www.example.com/status/',
            'api_access_address'    => 'Access API through IP or Hostname.',
            'api_access_ssl'        => 'When enabled, HTTPS is used by default for API access.',
            'access_ssl'            => 'When enabled, the user access web panel defaults to HTTPS',
            'port'                  => 'Use module default port when empty. Some module does not recognize this setting.'
        ]
    ],
    'config'                    => [
        'title'                 => 'Settings',
        'tab'                   => [
            'base'              => 'Base',
            'cron'              => 'Cron',
            'template'          => 'Template'
        ],
        'tip'                       => 'Save before switching the tab',
        'app_name'                  => 'Website Name',
        'register'                  => 'Allow to Register',
        'tos'                       => 'Enable TOS Acceptance',
        'tos_url'                   => 'Terms of Service URL',
        'sug'                       => 'Generate Method of Service Username',
        'sug_domain'                => 'Random username',
        'sug_random'                => 'Generate from domain',
        'site_suu'                  => 'Domain Unique in the Whole Site',
        'site_sdu'                  => 'Username Unique in the Whole Site',
        'admin_email'               => 'Email Address',
        'cron'                      => 'Enable Cron',
        'suspend'                   => 'Enable Suspension',
        'suspend_days'              => 'Suspend Days',
        'terminate'                 => 'Enable Termination',
        'terminate_days'            => 'Termination Days',
        'template'                  => 'Template',
        'tpl_home_product'          => 'Recommend Product',
        'url'                       => 'System URL',
        'send_suspension_email'     => 'Send Suspension Email',
        'enable_unsuspension'       => 'Enable Unsuspension',
        'send_unsuspension_email'   => 'Send Unsuspension Email',
        'limit_activity_log'        => 'Limit Activity Log'
    ],
    'product'                   => [
        'tab'                   => [
            'base'              => 'Base',
            'price'             => 'Price',
            'api'               => 'Module Settings',
        ],
        'ena_stock'             => 'Enable Stock Control',
        'enable_udg'            => 'Enable Upgrade/Downgrade',
        'price'                 => [
            'addItem'           => 'Add Item (Delete with empty name)',
            'name'              => 'Name',
            'period'            => 'Period',
            'price'             => 'Price',
            'setup'             => 'Setup Fee',
            'enable'            => 'Enable',
            'auto_activate'     => 'Auto Activate',
            'allow_renew'       => 'Allow Renew with this Period',
            'unlimited_when_buy'=> 'Allow to select Unlimited When buy',
            'free_limit_days'   => 'Free Renew Limited days',
            'free_limit'        => 'Free Order Limit',
        ],
        'domain'                => [
            'free'              => 'Free Domain',
            'require'           => 'Require Domain'
        ],
        'server'                    => [
            'plugin'                => 'Module Name',
            'group'                 => 'Server Group',
        ]
    ],
    'user'                      => [
        'last_logon_at'         => 'Last Login at',
        'email_verified_at'     => 'Email Verified at',
        'reset_success'         => 'Password reset successfully',
        'reset_password'        => [
            'line1'             => 'A new password was generated by system.',
            'line2'             => 'Username: :user',
            'line3'             => 'Password: :pass',
            'line4'             => 'Please change the password after login as soon as possible.'
        ]
    ],
    'sort_order'                => 'Sort Order',
    'ticket'                    => [
        'active'                => 'Include in Active Tickets',
        'awaiting'              => 'Include in Awaiting Reply',
        'auto_close'            => 'Auto Close',
        'status_color'          => 'Status Color',
        'reply'                 => '回复'
    ],
    'department'                => [
        'assign'                => 'Assign',
        'client_only'           => 'Client Only',
        'assign_help'           => 'Once the administrators are assigned, they will receive the mails of opening and '.
            'replying tickets from the clients for this department. Also, they have permissions to reply or close the tickets.',
        'client_only_help'      => 'Only client can choose this department if enabled.',
        'hide_help'             => 'This option only affect the page of departments selected. Opening ticket page can be seen all the time.'
    ],
    'server'                    => [
        'plugin'                => 'Module',
        'detail'                => 'Server Details',
        'access_hash'           => 'Access Hash',
        'max_load'              => 'Maximum No. of Accounts',
        'status_address'        => 'Server Status Address',
        'api_access_address'    => 'Access API By',
        'api_access_ssl'        => 'API through by SSL',
        'access_ssl'            => 'Web Panel through by SSL',
        'select_server_method'  => 'Fill Type',
        'fill_type'             => [
            0                   => 'Module decide',
            1                   => 'Add to the least full server',
            2                   => 'Fill active server until full then switch to next least used',
            3                   => 'Random'
        ]
    ],
    'service' => [
        'commands' => [
            'name' => 'Commands',
            'create' => 'Create',
            'suspend' => 'Suspend',
            'unsuspend' => 'Unsuspend',
            'terminate' => 'Terminate',
            'modal_body' => 'Are you sure you want to run the :command function?',
            'modal_title' => 'Confirm Module Command'
        ],
        'fields' => [
            'auto_terminate_end_of_cycle' => 'Auto-Terminate End of Cycle',
            'cancel_reason' => 'Cancel Reason',
            'suspend_reason' => 'Suspend Reason',
            'extra' => 'Extra Settings'
        ]
    ]
];
