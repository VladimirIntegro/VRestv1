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
     * Get data according to parameters.
     * 
     * @param array $params Data parameters list. Can be empty.
     * @return array 
     */
    public function getData(array $params = null) {
        $prices = $this->dataStorage->getData(["price", "town" , "date", "type"], "price_stat", $params);
        if(!$prices) {
            throw new Exception("VRest: Error with getting prices");
        }
        return $prices;
    }
    
    /**
     * Set data.
     * 
     * @param array $data Data array to write
     * @return int
     */
    public function setData(array $data) {
        return $this->dataStorage->setData($data, "price_stat");
    }
    
}
