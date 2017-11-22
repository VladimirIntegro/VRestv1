<?php
// src/AppBundle/Entity/Authenticator.php
namespace AppBundle\Entity;

use AppBundle\Entity\AuthenticatorInterface;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * Authenticator of the API referer.
 */
class Authenticator implements AuthenticatorInterface {
    
    /**
     * @var array $allowedIPs Referer allowed IP addresses
     */
    private $allowedIPs;
    
    /**
     * @var string $apiSecretKey The API secret key to check
     */
    private $apiSecretKey;
    
    /**
     * @param array $allowedIPs Referer allowed IP addresses
     * @param string $apiSecretKey The API secret key to check
     */
    public function __construct(array $allowedIPs, string $apiSecretKey)
    {
        $this->allowedIPs = $allowedIPs;
        $this->apiSecretKey = $apiSecretKey;
    }
    
    /**
     * Check IP address
     * 
     * @return bool 
     */
    public function checkIP() {
        if( isset($_SERVER['REMOTE_ADDR']) && 
            in_array($_SERVER['REMOTE_ADDR'], $this->allowedIPs, true) ) {
            return true;
        }
        else {
            return false;
        }
    }
    
    /**
     * Check token
     * 
     * @param string $receivedToken Token to check
     * @return bool 
     */
    public function checkToken(string $receivedToken) {
        return ($receivedToken == $this->apiSecretKey) ? true : false;
    }
    
    /**
     * Validate referer
     * 
     * @param array $authParams All parameters list
     * @return bool 
     */
    public function validate(array $authParams) {
        if( $this->checkIP() && $this->checkToken($authParams[0]) ) {
            return true;
        }
        else {
            return false;
        }
    }
    
}
