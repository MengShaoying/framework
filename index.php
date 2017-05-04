<?php
spl_autoload_register(function($className) {
    //$sysDir = __DIR__.'/../system';/* 外移一个目录 */
    $sysDir = __DIR__;
    $userApp = $sysDir.'/'.(isset($_GET['app']) ? $_GET['app'] : 'application').'/controller/'.$className.'.class.php';
    $coreApp = $sysDir.'/core/'.$className.'.class.php';
    if (file_exists($userApp)) {
        require_once $userApp;
    } elseif (file_exists($coreApp)) {
        require_once $coreApp;
    }
});

core_config::$config = require_once 'config/config.php';

if (isset($_GET['m']) && isset($_GET['act'])) {
    (new $_GET['m']())->$_GET['act']();
}
if (isset($_GET['m']) && !isset($_GET['act'])) {
    (new $_GET['m']())->index();
}
if (!isset($_GET['m']) && isset($_GET['act'])) {
    (new index())->$_GET['act']();
}
if (!isset($_GET['m']) && !isset($_GET['act'])) {
    (new index())->index();
}