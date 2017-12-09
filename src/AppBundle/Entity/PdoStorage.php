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
        //$conn = new PDO('mysql:host=localhost;dbname=someDb', $username, $password);
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
            //echo $e->getMessage();
        }
    }
    
    /**
     * Get data
     * 
     * @return string 
     */
    public function get() {
        // prepare query statement
        //$stmt = $this->conn->prepare($query);
        // execute the query
        //$stmt->execute();
        return "test get";
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPrices(string $dateFrom = null, string $dateTo = null, array $types = null, array $towns = null) {
        // prepare query statement
        $queryStr = "SELECT price,town,date,type FROM price_stat";
        $executeParams = [];
        /*if($dateFrom || $dateTo || $types || $towns) {
            $queryStr .= " WHERE";
            if($dateFrom) {
                $queryStr .= " date >= :datefr";
                $executeParams[":datefr"] = $dateFrom;
            }
            if($dateTo) {
                $queryStr .= " AND date <= :dateto";
                $executeParams[":dateto"] = $dateTo;
            }
            if($types) {
                $queryStr .= " AND type IN (:types)";
                $executeParams[":types"] = implode(",", $types);
            }
            if($towns) {
                $queryStr .= " AND town IN (:towns)";
                $executeParams[":towns"] = implode(",", $towns);
            }
        }*/
        if($dateFrom || $dateTo || $types || $towns) {
            $queryStr .= " WHERE";
            if($dateFrom) {
                $queryStr .= " date >= ?";
                // If the date is timestamp format convert it to the string in format Y-m-d to compare with
                if(is_int($dateFrom)) {
                    $dateFrom = date("Y-m-d", $dateFrom);
                }
                $executeParams[] = $dateFrom;
            }
            if($dateTo) {
                $queryStr .= " AND date <= ?";
                // If the date is timestamp format convert it to the string in format Y-m-d to compare with
                if(is_int($dateTo)) {
                    $dateTo = date("Y-m-d", $dateTo);
                }
                $executeParams[] = $dateTo;
            }
            if($types) {
                $inPlace  = str_repeat('?,', count($types) - 1) . '?';
                $queryStr .= " AND type IN ($inPlace)";
                //$executeParams[] = implode(",", $types);
                $executeParams = array_merge($executeParams, $types);
            }
            if($towns) {
                $inPlace  = str_repeat('?,', count($towns) - 1) . '?';
                $queryStr .= " AND town IN ($inPlace)";
                //$executeParams[] = implode(",", $towns);
                $executeParams = array_merge($executeParams, $towns);
            }
        }
        $stmt = $this->conn->prepare($queryStr);
        //return $executeParams;
        // execute the query
        $prices = [];
        $execRet = false;
        if(empty($executeParams)) {
            $execRet = $stmt->execute();
        }
        else {
            $execRet = $stmt->execute($executeParams);
        }
        if($execRet) {
            //while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //    $prices[] = $row;
            //}
            $prices = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        //$ret[] = $queryStr;
        //$ret[] = $executeParams;
        //$ret[] = $execRet;
        //$ret[] = $prices;
        //return print_r($executeParams, true);
        return (empty($prices)) ? false : $prices;
    }
    
}
