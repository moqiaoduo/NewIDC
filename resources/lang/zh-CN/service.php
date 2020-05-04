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

        'hosting'=>'虚拟主机',
        'reseller'=>'分销主机',
        'vps'=>'VPS',
        'server'=>'独立服务器',
        'others'=>'其他',
    ],
    'status' => [
        'pending' => '待开通',
        'active' => '运行中',
        'suspended' => '已暂停',
        'terminated' => '已销毁',
        'cancelled' => '已取消'
    ],
    'mail' => [
        'suspend' => [
            'lines' => [
                '您的服务刚刚被暂停了',
                '原因：:reason',
                '如有疑问，请通过工单联系网站管理员。'
            ],
            'action' => '查看服务',
            'subject' => '您在:website的服务已被暂停'
        ]
    ],
    'expire_suspend' => '逾期未付款'
];
