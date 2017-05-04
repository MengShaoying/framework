<?php
class core_controller {
    public function __construct() {}
    protected function template($dirFile='') {
        $app = isset($_GET['app']) ? $_GET['app'] : 'application';
        $dir = isset($_GET['m']) ? $_GET['m'] : 'index';
        $fil = isset($_GET['act']) ? $_GET['act'] : 'index';
        if (!empty($dirFile)) {
            $str = explode('/', $dirFile);
            if (count($str, COUNT_NORMAL) > 1) {
                $dir = $str[0];
                $fil = $str[1];
            } else {
                $fil = $str[0];
            }
        }
        require __DIR__ . '/../' . $app . '/templates/' . $dir . '/' . $fil . '.html';
    }
}
