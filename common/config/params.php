<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'pageSize'=>[
        'manage'=>3,
        'user'   => 10,
        'product' => 10,
        'frontproduct' => 9,
        'order' => 10,
    ],
    'defaultValue' => [
       'avatar' => 'shopassets/admin/img/contact-img.png',
    ],
    'express' => [
        1 => '中通快递',
        2 => '顺丰快递',
    ],
    'expressPrice' => [
        1 => 15,
        2 => 20,
    ],
];
