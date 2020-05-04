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

        'hosting'=>'Shared Hosting',
        'reseller'=>'Reseller Hosting',
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
    'mail' => [
        'suspend' => [
            'lines' => [
                'Your service was suspended just now.',
                'Reason: :reason',
                'If any confused, please contact Website Administrator by Ticket System.'
            ],
            'action' => 'View Service',
            'subject' => 'Your Service on :website was suspended'
        ]
    ],
    'expire_suspend' => 'Overdue payment'
];
