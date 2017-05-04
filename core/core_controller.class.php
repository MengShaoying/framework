<?php
class core_controller {
    protected $param = null;
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
        $param = $this->param;
        $this->param = null;
        require __DIR__ . '/../' . $app . '/templates/' . $dir . '/' . $fil . '.html';
    }
    protected function setParam($key, $value) {
        $this->param[$key] = $value;
    }
}
