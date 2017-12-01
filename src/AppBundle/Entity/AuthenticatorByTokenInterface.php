<?php
// src/AppBundle/Entity/AuthenticatorByTokenInterface.php
namespace AppBundle\Entity;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * Interface for Authenticator of the API referer by token.
 */
interface AuthenticatorByTokenInterface {
    
    /**
     * Check token
     * 
     * @param string $receivedToken Token to check
     * @return bool 
     */
    public function checkToken(string $receivedToken);
    
}
