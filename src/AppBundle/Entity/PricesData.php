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
     * @return array
     */
    public function get() {
        $dates = $this->currentAndPreviousDate();
        //$curDatePrices = $this->dataStorage->getAveragedPricesByDate($dates["current"]);
        //$prevDatePrices = $this->dataStorage->getAveragedPricesByDate($dates["previous"]);
        $curDatePrices = $this->dataStorage->getAveragedPricesByDate("2017-09-26");
        $prevDatePrices = $this->dataStorage->getAveragedPricesByDate("2017-09-25");
        if(!$curDatePrices || !$prevDatePrices) {
            throw new Exception("VRest: Error with getting prices");
        }
        return $curDatePrices;
    }
    
}
