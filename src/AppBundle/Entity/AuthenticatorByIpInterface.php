<?php
// src/AppBundle/Entity/AuthenticatorByIpInterface.php
namespace AppBundle\Entity;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * Interface for Authenticator of the API referer by IP address.
 */
interface AuthenticatorByIpInterface {
    
    /**
     * Check IP address
     * 
     * @return bool 
     */
    public function checkIp();
    
}
