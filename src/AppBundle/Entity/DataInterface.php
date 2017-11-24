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
     * @return array 
     */
    public function getPricesByDateInterval(string $dateFrom, string $dateTo);
    
}
