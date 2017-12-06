<?php
// src/AppBundle/Entity/DataInterface.php
namespace AppBundle\Entity;

//use ConverterApp\Entity\Validator;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * Interface for processing data.
 */
interface DataInterface {
    
    /**
     * Get averaged prices and difference between current and previous date prices for each town.
     * 
     * @param int $dateFrom Date in timestamp format
     * @param int $dateTo Date in timestamp format
     * @param array $types Prices types list
     * @param array $towns Towns list
     * @return array 
     */
    public function getAllPrices(string $dateFrom = null, string $dateTo = null, array $types = null, array $towns = null);

    /**
     * Get averaged prices and difference between current and previous date prices for each town.
     * 
     * @param int $dateFrom Date in timestamp format
     * @param int $dateTo Date in timestamp format
     * @return array
     */
    public function getAveragedPricesByDateInterval(string $dateFrom, string $dateTo);
    
}
