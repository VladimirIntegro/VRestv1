<?php
// src/AppBundle/Entity/DataStorageInterface.php
namespace AppBundle\Entity;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * Data storage interface. Abstraction for work with any DB or any other sources of data.
 */
interface DataStorageInterface {
    
    /**
     * Initializes the data storage
     */
    public function init();
    
    /**
     * Get data
     * 
     * @param array $fieldsToGet Fields list to return
     * @param array $dataSource Source of the data (DB table name, file name...)
     * @param array $params Filter for the data in format ["name", "clause", "value"]
     * @return array|null|FALSE Array of prices
     */
    public function getData(array $fieldsToGet = null, string $dataSource = null, array $params = null);
    
    /**
     * Set data.
     * 
     * @param array $data Data array to write
     * @param array $dataSource Source of the data (DB table name, file name...)
     * @return int
     */
    public function setData(array $data, string $dataSource = null);
    
}
