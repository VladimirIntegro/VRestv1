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
     * Get averaged prices for towns by date
     * 
     * @param string $date Date in string format "Y-m-d"
     * @return array|null|FALSE Array of prices
     */
    public function getAveragedPricesByDate(string $date) {
        // prepare query statement
        $stmt = $this->conn->prepare("SELECT price,town FROM price_stat WHERE date = :date AND type=20");
        //print_r($stmt); exit;
        //$date = "2017-09-26";
        // execute the query
        $prices = [];
        if($stmt->execute([":date" => $date])) {
            //while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //    $prices[] = $row;
            //}
            $prices = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return (empty($prices)) ? false : $prices;
    }
    
}
