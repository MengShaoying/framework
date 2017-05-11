<?php
class core_mysqlpdo {
    protected $type     = '';
    protected $host     = '';
    protected $dbname   = '';
    protected $user     = '';
    protected $password = '';
    protected $longConnect = false;
    protected $pdoObj   = null;
    public    $error    = '';
    public function __construct($config) {
        $this->type     = $config['type'];
        $this->host     = $config['host'];
        $this->dbname   = $config['dbname'];
        $this->user     = $config['user'];
        $this->password = $config['password'];
        $this->longConnect = $config['longConnect'];
    }
    public function connect() {
        $dbh = $this->type.':host='.$this->host.';dbname='.$this->dbname;
        if ($this->longConnect) {
            $this->pdoObj = new PDO($dbh, $this->user, $this->password, array(PDO::ATTR_PERSISTENT=>true));
        } else {
            $this->pdoObj = new PDO($dbh, $this->user, $this->password);
        }
    }
    public function beginTrans() {
        if (is_null($this->pdoObj)) {
            $this->connect();
        }
        $this->pdoObj->beginTransaction();
    }
    public function commit() {
        $this->pdoObj->commit();
    }
    public function rollback() {
        $this->pdoObj->rollback();
    }
    public function exesql($cmd) {
        if (is_null($this->pdoObj)) {
            $this->connect();
        }
        return $this->pdoObj->exec($cmd);
    }
    public function query($cmd) {
        if (is_null($this->pdoObj)) {
            $this->connect();
        }
        $result = $this->pdoObj->query($cmd);
        if (false === $result) {
            return $result;
        }
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
