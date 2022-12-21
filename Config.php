<?php
//是否启用 Server 酱 通知
//true: 启用  false: 不启用
define("SERVER_CHAN_STATE", false);
define("TG_STATE", false);
define("BARK_STATE", false);
define("Go_cqhttp_STATE", false);

$config = [
    //Server酱：http://sc.ftqq.com/
    'SERVER_CHAN' => [
        '这里填你的超星账号 1' => [
            'state' => true,//是否启用 Server酱 通知，true: 启用 false: 不启用

            //填入该值，表示你使用的是新版推送通道。旧版推送通道将于 2021年4月 下线
            //SendKey 获取地址：https://sct.ftqq.com/sendkey
            'SendKey' => '',
        ],
        '这里填你的超星账号 2' => [
            'state' => true,//是否启用 Server酱 通知，true: 启用 false: 不启用

            //填入该值，表示你使用的是新版推送通道。旧版推送通道将于 2021年4月 下线
            // SendKey 获取地址：https://sct.ftqq.com/sendkey
            'SendKey' => '',
        ],
        //... 多账号部署
    ],
    'Telegram' => [
        '这里填你的超星账号 1' => [
            'state' => true,
            'TG_CHAT_ID' => '',
            'TG_BOT_TOKEN' => '',
        ]
    ],
    'Bark' => [
        '这里填你的超星账号 1' => [
            'state' => true,
            'BARK_PUSH_API' => ''
        ]
    ],
    'Go-cqhttp' => [
        '这里填你的超星账号 1' => [
            'state' => true,
            'API' => '',//示例：http://domain.com:5700/send_private_msg
            'access-token' => ''
        ]
    ]
    //TODO: 接入钉钉机器人通知
];