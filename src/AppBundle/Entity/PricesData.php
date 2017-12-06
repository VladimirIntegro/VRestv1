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
     * Get averaged prices and difference between current and previous date prices for each town.
     * 
     * @param int $dateFrom Date in timestamp format
     * @param int $dateTo Date in timestamp format
     * @param array $types Prices types list
     * @param array $towns Towns list
     * @return array 
     */
    public function getAllPrices(string $dateFrom = null, string $dateTo = null, array $types = null, array $towns = null) {
        //$dates = $this->currentAndPreviousDate();
        //$curDatePrices = $this->dataStorage->getAveragedPricesByDate($dates["current"]);
        //$prevDatePrices = $this->dataStorage->getAveragedPricesByDate($dates["previous"]);
        //$curDatePrices = $this->dataStorage->getAveragedPricesByDate("2017-09-26");
        //$prevDatePrices = $this->dataStorage->getAveragedPricesByDate("2017-09-25");
        //$dateFrom = date("Y-m-d", $dateFrom);
        //$dateTo = date("Y-m-d", $dateTo);
        
        //$prices = $this->dataStorage->getByDateInterval($dateFrom, $dateTo);
        //$prices = $this->dataStorage->getPricesForDates("2017-09-25", "2017-09-26");
        $prices = $this->dataStorage->getPrices("2017-09-25", "2017-09-26", $types, $towns);
        if(!$prices) {
            throw new Exception("VRest: Error with getting prices");
        }
        return $prices;
    }

    /**
     * Get averaged prices and difference between current and previous date prices for each town.
     * 
     * @param int $dateFrom Date in timestamp format
     * @param int $dateTo Date in timestamp format
     * @return array
     */
    public function getAveragedPricesByDateInterval(string $dateFrom, string $dateTo) {
        //$dates = $this->currentAndPreviousDate();
        //$curDatePrices = $this->dataStorage->getAveragedPricesByDate($dates["current"]);
        //$prevDatePrices = $this->dataStorage->getAveragedPricesByDate($dates["previous"]);
        //$curDatePrices = $this->dataStorage->getAveragedPricesByDate("2017-09-26");
        //$prevDatePrices = $this->dataStorage->getAveragedPricesByDate("2017-09-25");
        //$dateFrom = date("Y-m-d", $dateFrom);
        //$dateTo = date("Y-m-d", $dateTo);
        
        //$prices = $this->dataStorage->getByDateInterval($dateFrom, $dateTo);
        //$prices = $this->dataStorage->getAveragedPricesForDates("2017-09-25", "2017-09-26");
        $prices = $this->dataStorage->getPrices("2017-09-25", "2017-09-26", [20]);
        if(!$prices) {
            throw new Exception("VRest: Error with getting prices");
        }
        return $prices;
    }
    
}
