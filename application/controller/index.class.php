<?php
class index extends core_controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $h1 = new core_cache('ortherServer');
        $list = $h1->table('account')->limit(10)->select();
        var_dump($h1);
        var_dump($list);
        $this->template();
    }
    public function make() {
        var_dump($_POST);
    }
}
