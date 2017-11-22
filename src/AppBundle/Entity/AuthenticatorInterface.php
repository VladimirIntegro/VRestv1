<?php
// src/AppBundle/Entity/AuthenticatorInterface.php
namespace AppBundle\Entity;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * Interface for Authenticator of the API referer.
 */
interface AuthenticatorInterface {
    
    /**
     * Check IP address
     * 
     * @return bool 
     */
    public function checkIP();
    
    /**
     * Check token
     * 
     * @param string $receivedToken Token to check
     * @return bool 
     */
    public function checkToken(string $receivedToken);
    
    /**
     * Validate referer
     * 
     * @param array $authParams All parameters list
     * @return bool 
     */
    public function validate(array $authParams);
    
}
