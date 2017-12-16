<?php
// src/AppBundle/Entity/PricesData.php
namespace AppBundle\Entity;

use AppBundle\Entity\DataInterface;
use AppBundle\Entity\DataStorageInterface;
use Exception;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * Implements DataInterface. Processes averaged prices data.
 */
class PricesData implements DataInterface {
    
    /**
     * @var AppBundle\Entity\DataStorageInterface Data storage
     */
    private $dataStorage;
    
    /**
     * 
     * 
     * @param string $aStorage Data storage object
     * @return string 
     */
    public function __construct(DataStorageInterface $aStorage) {
        $this->dataStorage = $aStorage;
    }
    
    private function currentAndPreviousDate() {
        return [
                "current" => date("Y-m-d"),
                "previous" => date("Y-m-d", time() - 86400)
            ];
    }

    /**
     * Get all prices for the interval by types and towns
     * 
     * @param string $dateFrom Date
     * @param string $dateTo Date
     * @param array $types Prices types list
     * @param array $towns Towns list
     * @return array 
     */
    public function getAllPrices(string $dateFrom = null, string $dateTo = null, array $types = null, array $towns = null) {
        $prices = $this->dataStorage->getPrices($dateFrom, $dateTo, $types, $towns);
        if(!$prices) {
            throw new Exception("VRest: Error with getting prices");
        }
        return $prices;
    }

    /**
     * Get averaged prices and difference between current and previous date prices for each town.
     * 
     * @param string $dateFrom Date
     * @param string $dateTo Date
     * @return array
     */
    public function getAveragedPricesByDateInterval(string $dateFrom, string $dateTo) {
        $prices = $this->dataStorage->getPrices($dateFrom, $dateTo, [20]);
        if(!$prices) {
            throw new Exception("VRest: Error with getting prices");
        }
        return $prices;
    }
    
    /**
     * Set prices.
     * 
     * @param array $data Data array to save
     * @return int
     */
    public function setPrices(array $data) {
        return $this->dataStorage->savePrices($data);
    }
    
}
