<?php
class core_model extends core_mysqlpdo {
    protected $_prefix = '';
    protected $_table  = '';
    protected $_field  = '*';
    protected $_where  = '';
    protected $_group  = '';
    protected $_order  = '';
    protected $_limit  = '';
    protected $_lastSql = '';
    public function __construct() {
        parent::__construct();
        $this->_prefix = core_config::$config['database']['prefix'];
    }
    public function prefix($prefix) {
        $this->_prefix = $prefix;
        return $this;
    }
    public function table($tb) {
        $this->_table = $tb;
        return $this;
    }
    public function field($farr='*') {
        if (is_array($farr)) {
            $this->_field = '';
            foreach ($farr as $value) {
                if ('' != $this->_field) {
                    $this->_field .= ',';
                }
                $this->_field .= '`'.$value .'`';
            }
            return $this;
        }
        $this->_field = $farr;
        return $this;
    }
    public function where($condition) {
        if (is_array($condition)) {
            $this->_where = '';
            foreach ($condition as $key =>$value) {
                if ('' != $this->_where) {
                    $this->_where .= ' AND ';
                }
                $this->_where .= '`'.$key.'`="'.$value.'"';
            }
            return $this;
        }
        $this->_where = $condition;
        return $this;
    }
    public function group($group='') {
        $this->_group = $group;
        return $this;
    }
    public function order($order='') {
        $this->_order = $order;
        return $this;
    }
    public function limit($lim='') {
        if (is_string($lim)) {
            $this->_limit = $lim;
        } else {
            $this->_limit = '0,'.$lim;
        }
        return $this;
    }
    protected function _makeSql() {
        $this->_lastSql = 'SELECT '.$this->_field.' FROM `'.$this->_prefix.$this->_table.'`';
        if (!empty($this->_where)) {
            $this->_lastSql .= ' WHERE '.$this->_where;
        }
        if (!empty($this->_group)) {
            $this->_lastSql .= ' GROUP BY '.$this->_group;
        }
        if (!empty($this->_order)) {
            $this->_lastSql .= ' ORDER BY '.$this->_order;
        }
        if (!empty($this->_limit)) {
            $this->_lastSql .= ' LIMIT '.$this->_limit;
        }
    }
    public function select() {
        $this->_makeSql();
        return $this->query($this->_lastSql);
    }
    public function find() {
        $this->_limit = '0,1';
        $this->_makeSql();
        $data = $this->query($this->_lastSql);
        if (false === $data) {
            return false;
        }
        if (empty($data)) {
            return array();
        }
        return $data[0];
    }
    public function get($name) {
        $this->_field = '`'.$name.'`';
        $this->_limit = '0,1';
        $this->_makeSql();
        $data = $this->query($this->_lastSql);
        if (false === $data) {
            return false;
        }
        if (empty($data)) {
            return array();
        }
        return $data[0][$name];
    }
    public function insert($data) {
        $this->_lastSql = 'INSERT INTO `'.$this->_prefix.$this->_table.'` SET ';
        $datas = '';
        foreach ($data as $key => $value) {
            if (!empty($datas)) {
                $datas .= ',';
            }
            $datas .= '`'.$key.'`="'.$value.'"';
        }
        $this->_lastSql .= $datas;unset($datas);
        $result = $this->exesql($this->_lastSql);
        if (false !== $result) {
            return $this->pdoObj->lastInsertId();
        } else {
            return $result;
        }
    }
    public function update($data) {
        $this->_lastSql = 'UPDATE `'.$this->_prefix.$this->_table.'` SET ';
        $datas = '';
        foreach ($data as $key => $value) {
            if (!empty($datas)) {
                $datas .= ',';
            }
            $datas .= '`'.$key.'`="'.$value.'"';
        }
        $this->_lastSql .= $datas;unset($datas);
        $this->_lastSql .= ' WHERE '.$this->_where;
        return $this->exesql($this->_lastSql);
    }
    public function delete() {
        $this->_lastSql = 'DELETE FROM `'.$this->_prefix.$this->_table.'`';
        if (!empty($this->_where)) {
            $this->_lastSql .= ' WHERE '.$this->_where;
        }
        return $this->exesql($this->_lastSql);
    }
    public function getLastSql() {
        return $this->_lastSql;
    }
}
