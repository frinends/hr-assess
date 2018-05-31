<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'name'      =>"人力资源考核系统",
    'id'        => 'basic',
    'basePath'  => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => "site/login",
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'n8IzBFV9KV2HrUTzu9IxiohzU_zGEd4y',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class'     => 'Swift_SmtpTransport',
                'host'      => 'mail.163.cc',  //每种邮箱的host配置不一样
                'username'  => 'xxxxx@163.cc',
                'password'  => '123456',
                'port'      => '25',
//                'encryption' => 'tls',          
            ],
            'messageConfig'=>[
                'charset'   => 'UTF-8',
                'from'      => ['xxxxx@163.cc'=>'人力资源部']
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            "suffix" => "",
            "rules" => [
                "<controller:\w+>/<id:\d+>"=>"<controller>/view",
                "<controller:\w+>/<action:\w+>"=>"<controller>/<action>"
            ],
        ],

    ],
//    'as access' => [
//        'class' => 'mdm\admin\components\AccessControl',
//        'allowActions' => [
//            'site/*', //sites for access
//            'admin/*', // allow everyone to access 'admin'
//        ]
//    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*']
    ];
}

return $config;
