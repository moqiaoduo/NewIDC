<?php

use App\Exceptions\ServiceCreateException;

return [
    'errors' => [
        ServiceCreateException::NO_SERVER_AVAILABLE => "There is no server available now."
    ],
    'type' => [
        /**
         * 关于一些type选项的翻译，顺便作为一个列表
         */

        'hosting'=>'Hosting',
        'reseller'=>'Reseller',
        'vps'=>'VPS',
        'server'=>'Dedicated Server',
        'others'=>'Others',
    ],
    'status' => [
        'pending' => 'Pending',
        'active' => 'Active',
        'suspended' => 'Suspended',
        'terminated' => 'Terminated',
        'cancelled' => 'Cancelled'
    ],
    'detail' => [
        'tab' => [
            'overview' => 'Overview',
            'change_password' => 'Change Password'
        ]
    ]
];
