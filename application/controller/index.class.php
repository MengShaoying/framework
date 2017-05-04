<?php
class index extends core_controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $handle = new core_cache();
        $res = $handle->table('account')->select();
        var_dump($res);
        var_dump($handle);
        
        $this->template();
    }
}
