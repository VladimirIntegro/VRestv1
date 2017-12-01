<?php
// src/AppBundle/Entity/AuthenticatorByUserPwInterface.php
namespace AppBundle\Entity;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * Interface for Authenticator of the API referer by user and password.
 */
interface AuthenticatorByUserPwInterface {
    
    /**
     * Checks user name
     * 
     * @return bool 
     */
    public function checkUserName();
    
    /**
     * Checks password
     * 
     * @return bool 
     */
    public function checkUserPassword();
    
}
