<?php
// src/AppBundle/Entity/DataStorageInterface.php
namespace AppBundle\Entity;

//use ConverterApp\Entity\Validator;

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
     */
    public function get();
    
    /**
     * Get all prices for date interval by object types
     * 
     * @param string $dateFrom Date in string format "Y-m-d"
     * @param string $dateTo Date in string format "Y-m-d"
     * @param array $types Prices types list
     * @param array $towns Towns list
     * @return array|null|FALSE Array of prices
     */
    public function getPrices(string $dateFrom = null, string $dateTo = null, array $types = null, array $towns = null);
    
    /**
     * Get averaged prices for towns by date
     * 
     * @param string $dateFrom Date in string format "Y-m-d"
     * @param string $dateTo Date in string format "Y-m-d"
     * @return array|null|FALSE Array of prices
     */
    //public function getAveragedPricesForDates(string $dateFrom, string $dateTo);
    
}
