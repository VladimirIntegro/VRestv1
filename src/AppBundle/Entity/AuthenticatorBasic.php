<?php
// src/AppBundle/Entity/AuthenticatorBasic.php
namespace AppBundle\Entity;

use AppBundle\Entity\Authenticator;
use AppBundle\Entity\AuthenticatorByUserPwInterface;
use AppBundle\Entity\AuthenticatorByIpInterface;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * Basic authenticator of the API referrer.
 */
class AuthenticatorBasic extends Authenticator implements AuthenticatorByUserPwInterface, 
                                                     AuthenticatorByIpInterface {
    
    /**
     * Check IP address
     * 
     * @return bool 
     */
    public function checkIp() {
        if( isset($_SERVER['REMOTE_ADDR']) && 
            in_array($_SERVER['REMOTE_ADDR'], $this->getAuthParams()["allowedips"], true) ) {
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
    //public function checkToken(string $receivedToken) {
    //    $secretKey = base64_encode(md5($this->apiSecretKey, true));
    //    return ($receivedToken == $secretKey) ? true : false;
    //}
    
    /**
     * Checks user name
     * 
     * @return bool 
     */
    public function checkUserName() {
        if( isset($_SERVER['PHP_AUTH_USER']) && 
            $_SERVER['PHP_AUTH_USER'] == $this->getAuthParams()["username"] ) {
            return true;
            }
        else {
            return false;
        }
    }
    
    /**
     * Checks password
     * 
     * @return bool 
     */
    public function checkUserPassword() {
        if( isset($_SERVER['PHP_AUTH_PW']) && 
            $_SERVER['PHP_AUTH_PW'] == $this->getAuthParams()["userpassw"] ) {
            return true;
            }
        else {
            return false;
        }
    }
    
    /**
     * Validate referrer
     * 
     * @return bool True if the authentication parameters is valid
     */
    public function validate() {
        if( $this->checkIp() && $this->checkUserName() && $this->checkUserPassword() ) {
            return true;
        }
        else {
            return false;
        }
    }
    
}
