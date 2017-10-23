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
     * Get data
     * 
     * @param string $aRequestMethod
     * @return string 
     */
    public function get();
    
}
