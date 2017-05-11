<?php
$a = microtime();
spl_autoload_register(function($className) {
    $app = isset($_GET['app']) ? $_GET['app'] : 'application';
    //$sysDir = __DIR__.'/../system';/* 外移一个目录 */
    $sysDir = __DIR__;
    $userApp = $sysDir.'/'.$app.'/controller/'.$className.'.class.php';
    $coreApp = $sysDir.'/core/'.$className.'.class.php';
    $model   = $sysDir.'/model/'.$className.'.class.php';
    if (file_exists($userApp)) {
        require_once $userApp;
    } elseif (file_exists($coreApp)) {
        require_once $coreApp;
    } elseif (file_exists($model)) {
        require_once $model;
    } else {
        echo '找不到类'.$className.'的代码文件';
        die();
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
$b = microtime();
function diff_time($str1, $str2) {
    $t1 = explode(' ', $str1);
    $t2 = explode(' ', $str2);
    $usec = $t2[0] - $t1[0];
    $sec  = $t2[1] - $t1[1];
    return $sec + $usec;
}
//echo diff_time($a, $b).'s';