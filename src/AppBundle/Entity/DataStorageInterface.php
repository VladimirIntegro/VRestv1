<?php
// src/AppBundle/Entity/DataStorageInterface.php
namespace AppBundle\Entity;

//use ConverterApp\Entity\Validator;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * Data storage interface. Abstraction for work with any DB or any other sources.
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
    
}
