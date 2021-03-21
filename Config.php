<?php
//是否启用 Server 酱 通知
//true: 启用  false: 不启用
define("SERVER_CHAN_STATE", true);

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

    //TODO: 接入钉钉机器人通知
];