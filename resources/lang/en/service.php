<?php

use App\Exceptions\ServiceCreateException;

return [
    'errors' => [
        ServiceCreateException::NO_SERVER_AVAILABLE => "There is no server available now."
    ],
    'type' => [
        /**
         * A list of Type
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
        'activate' => [
            'lines' => [
                'Your service :service is active now.',
                'Username: :username',
                'Password: :password',
                'Domain: :domain',
                'Thank you for choosing :website.'
            ],
            'action' => 'View Service',
            'subject' => 'Your Service on :website is active'
        ],
        'suspend' => [
            'lines' => [
                'Your service :service was suspended just now.',
                'Reason: :reason',
                'If any confused, please contact Website Administrator by Ticket System.'
            ],
            'action' => 'View Service',
            'subject' => 'Your Service on :website was suspended'
        ],
        'unsuspend' => [
            'lines' => [
                'Your service :service is unsuspended now.',
                'If any confused, please contact Website Administrator by Ticket System.'
            ],
            'action' => 'View Service',
            'subject' => 'Your Service on :website is unsuspended'
        ],
        'terminate' => [
            'lines' => [
                'Your service :service was terminated just now.',
                'If any confused, please contact Website Administrator by Ticket System.'
            ],
            'action' => 'View Service',
            'subject' => 'Your Service on :website was terminated'
        ]
    ],
    'expire_suspend' => 'Overdue payment'
];
