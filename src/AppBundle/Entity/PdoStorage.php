<?php
// src/AppBundle/Entity/PdoStorage.php
namespace AppBundle\Entity;

use AppBundle\Entity\DataStorageInterface;
use Exception;
use PDO;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * PDO storage.
 */
class PdoStorage implements DataStorageInterface {
    
    /**
     * @var array DB config
     */
    private $dbConfig;
    
    /**
     * @var PDO connection
     */
    private $conn;
    
    /**
     * @param array $dbConfig DB configuration
     */
    public function __construct(array $dbConfig)
    {
        $this->dbConfig = $dbConfig;
    }
    
    /**
     * Destructor.
     * Closes connection.
     */
    function __destruct() {
        if($this->conn) {
            $this->conn = null;
        }
    }
    
    /**
     * Creates DB connection.
     * @return bool|string TRUE if connection established. PDOException message if unsuccess
     * @throws \PDOException
     */
    public function init()
    {
        try {
            $this->conn = new PDO("mysql:host={$this->dbConfig['host']};dbname={$this->dbConfig['dbname']}", 
                                   $this->dbConfig['user'], $this->dbConfig['pass'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        }
        catch(\PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function getData(array $fieldsToGet = null, string $dataSource = null, array $params = null) {
        // prepare query statement
        $fieldsStr = implode(",", $fieldsToGet);
        $queryStr = "SELECT $fieldsStr FROM $dataSource";
        $executeParams = [];
        
        if($params) {
            $queryStr .= " WHERE";
            $whereStr = "";
            foreach($params as $param) {
                if($whereStr != "") {
                    $whereStr .= " AND";
                }
                if($param["clause"] == "IN") {
                    $inPlace  = str_repeat('?,', count($param["value"]) - 1) . '?';
                    $whereStr .= " {$param['name']} IN ($inPlace)";
                    $executeParams = array_merge($executeParams, $param["value"]);
                }
                else {
                    $whereStr .= " {$param['name']} {$param['clause']} ?";
                    $executeParams[] = $param["value"];
                }
            }
            $queryStr .= $whereStr;
        }
        
        $stmt = $this->conn->prepare($queryStr);
        // execute the query
        $retData = [];
        $execRet = false;
        if(empty($executeParams)) {
            $execRet = $stmt->execute();
        }
        else {
            $execRet = $stmt->execute($executeParams);
        }
        if($execRet) {
            $retData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        //return print_r($stmt->errorInfo(), true); // Check errors
        return (empty($retData)) ? false : $retData;
    }
    
    /**
     * Set data.
     * 
     * @param array $data Data array to write
     * @param array $dataSource Source of the data (DB table name, file name...)
     * @return int
     */
    public function setData(array $data, string $dataSource = null) {
        $placeholders = "";
        $valuesArrayToExecute = [];
        $colNames = [];
        $colNamesEmpty = true;
        foreach($data as $dataEl) {
            foreach($dataEl as $dataElEl) {
                if($colNamesEmpty) {
                    $colNames = array_keys($dataElEl, true);
                    $colNamesEmpty = false;
                }
                $placeholders .= "(" . str_repeat('?,', count($dataElEl) - 1) . '?),';
                foreach($dataElEl as $val) {
                    $valuesArrayToExecute[] = $val;
                }
            }
        }
        if(empty($colNames)) {
            return false;
        }
        $placeholders = trim($placeholders, ",");
        $queryStr = "INSERT INTO $dataSource (".implode(', ', $colNames).") VALUES ".$placeholders;
        $stmt = $this->conn->prepare($queryStr);
        return $stmt->execute($valuesArrayToExecute);
    }
    
}
