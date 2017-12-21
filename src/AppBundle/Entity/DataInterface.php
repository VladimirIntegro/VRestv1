<?php
// src/AppBundle/Entity/DataInterface.php
namespace AppBundle\Entity;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * Interface for processing data.
 */
interface DataInterface {
    
    /**
     * Get data according to parameters.
     * 
     * @param array $params Data parameters list. Can be empty.
     * @return array 
     */
    public function getData(array $params = null);
    
    /**
     * Set data.
     * 
     * @param array $data Data array to write
     * @return int
     */
    public function setData(array $data);
    
}
