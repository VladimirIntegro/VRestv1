<?php
// src/AppBundle/Entity/PricesData.php
namespace AppBundle\Entity;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * Logs all exceptions
 */
class Logger {
    
    /**
     * Writes error information to error log
     * 
     * @param string $message Message to log
     */
    public static function log($message) {
        error_log("LOGGER MESSAGE: $message");
    }
    
}
