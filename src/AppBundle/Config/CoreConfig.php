<?php
// src/AppBundle/Config/CoreConfig.php

/**
 * @copyright (c) 2017, Vladimir Zhitkov. All rights reserved.
 */

namespace AppBundle\Config;

/**
 * Application base configuration.
 * 
 * @author Vladimir Zhitkov
 */
class CoreConfig {
    const DB = [
        'host'=>'127.0.0.1',
        'user'=>'root',
        'pass'=>'kvadrat',
        'dbname'=>'podolska_ru2'
    ];
    
    //const ALLOWED_IPS = ["164.132.148.103"];
    const ALLOWED_IPS = ["127.0.0.1"];
    
    const API_SECRET_KEY = "3757DG4J7H2745DFU40HGOK4";
    
}