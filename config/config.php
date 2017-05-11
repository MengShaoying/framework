<?php
return array(
    'cache' => array(
        'dir' => __DIR__ . '/../cache/',
        'enable' => true,
    ),
    'serverList' => array(
        'myLocalServer' => array(
            'host' => '127.0.0.1',
            'dbname' => 'lig',
            'type' => 'mysql',
            'user' => 'root',
            'password' => '11111111',
            'prefix' => 'tf_',
            'longConnect' => false,
        ),
        'ortherServer' => array(
            'host' => '127.0.0.1',
            'dbname' => 'km',
            'type' => 'mysql',
            'user' => 'root',
            'password' => '11111111',
            'prefix' => 'is_',
            'longConnect' => false,
        ),
        'server3' => array(
            'host' => '127.0.0.2',
            'dbname' => 'test2',
            'type' => 'mysql',
            'user' => 'root',
            'password' => '11111111',
            'prefix' => 'pr_',
            'longConnect' => false,
        ),
    ),
);
