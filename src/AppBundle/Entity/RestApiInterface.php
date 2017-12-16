<?php
// src/AppBundle/Entity/RestApiInterface.php
namespace AppBundle\Entity;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * Interface for REST API's. Uses JSON format.
 */
interface RestApiInterface {
    
    /**
     * Processes a request.
     * 
     * @return array 
     */
    public function process();
    
}
