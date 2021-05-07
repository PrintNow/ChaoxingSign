<?php
//是否启用 Server 酱 通知
//true: 启用  false: 不启用
define("SERVER_CHAN_STATE", true);

$config = [
    //Server酱：http://sc.ftqq.com/
    'SERVER_CHAN' => [
        '这里填你的超星账号 1' => [
            'state' => true,//是否启用 Server酱 通知，true: 启用 false: 不启用
            'SCKEY' => '',//在 http://sc.ftqq.com/?c=code 获取
        ],
        '这里填你的超星账号 2' => [
            'state' => true,//是否启用 Server酱 通知，true: 启用 false: 不启用
            'SCKEY' => '',//在 http://sc.ftqq.com/?c=code 获取
        ],
        //... 多账号部署
    ],

    //TODO: 接入钉钉机器人通知
];