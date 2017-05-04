<?php
//$config = array();
//$config['database']['type'] = 'mysql';
//$config['database']['host'] = '127.0.0.1';
//$config['database']['dbname'] = 'test';
//$config['database']['user'] = 'root';
//$config['database']['password'] = '11111111';
//$config['database']['longConnect'] = false;/* 数据库长连接支持 */
//$config['database']['prefix'] = 'te_';

return array(
    'database' => array(
        'type' => 'mysql',
        'host' => '127.0.0.1',
        'dbname' => 'test',
        'user' => 'root',
        'password' => '123456789',
        'longConnect' => false,
        'prefix' => 'cr_',
    ),
    'cache' => array(
        'dir' => __DIR__ . '/../cache/',
        'enable' => true,
    ),
);
