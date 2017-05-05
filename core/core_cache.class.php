<?php
class core_cache extends core_model {
    protected $_cache = array();
    public function __construct() {
        parent::__construct();
        $this->_cache = core_config::get('cache');
    }
    private function _getDir() {
        return str_replace('\\','/',$this->_cache['dir'].$this->host.'/'.$this->dbname.'/'
            .$this->_prefix.$this->_table);
    }
    private function _getFile() {
        $this->_makeSql();
        return $this->_getDir().'/'.md5($this->_lastSql).'.cache';
    }
    private function _delDir($dir) {
        $dr = opendir($dir);
        while ($file = readdir($dr)) {
            if ('.' != $file && '..' != $file) {
                $fullPath = $dir .'/'. $file;
                if (!is_dir($fullPath)) {
                    unlink($fullPath);
                } else {
                    $this->_delDir($fullPath);
                }
            }
        }
    }
    private function _cacheSave($result, $file) {
        if (false === $result) {
            return false;
        }
        if (empty(@file_put_contents($file, serialize($result), LOCK_EX))) {
            mkdir($this->_getDir(),'0777',true);
            file_put_contents($file, serialize($result), LOCK_EX);
        }
        return $result;
    }
    public function select() {
        $file = $this->_getFile();
        if (false == $this->_cache['enable']) {
            return parent::select();
        } elseif (file_exists($file)) {
            return unserialize(file_get_contents($file));
        } else {
            return $this->_cacheSave(parent::select(), $file);
        }
    }
    public function find() {
        $this->_limit = '0,1';
        $file = $this->_getFile();
        if (false == $this->_cache['enable']) {
            return parent::find();
        } elseif (file_exists($file)) {
            return unserialize(file_get_contents($file));
        } else {
            return $this->_cacheSave(parent::find(), $file);
        }
    }
    public function get($name) {
        $this->_field = '`'.$name.'`';
        $this->_limit = '0,1';
        $file = $this->_getFile();
        if (false == $this->_cache['enable']) {
            return parent::get($name);
        } elseif (file_exists($file)) {
            return unserialize(file_get_contents($file));
        } else {
            return $this->_cacheSave(parent::get($name), $file);
        }
    }
    public function insert($data) {
        $result = parent::insert($data);
        if (!empty($result)) {
            $this->_delDir($this->_getDir());
            return $result;
        } else {
            return $result;
        }
    }
    public function update($data) {
        $result = parent::update($data);
        if (!empty($result)) {
            $this->_delDir($this->_getDir());
            return $result;
        } else {
            return $result;
        }
    }
    public function delete() {
        $result = parent::delete();
        if (!empty($result)) {
            $this->_delDir($this->_getDir());
            return $result;
        } else {
            return $result;
        }
    }
}
