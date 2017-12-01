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
abstract class Authenticator implements AuthenticatorInterface {
    
    /**
     * @var array $authParams All checking authentication parameters
     */
    private $authParams;
    
    /**
     * @param array $authParams Authentication parameters to check
     */
    public function __construct(array $authParams)
    {
        $this->authParams = $authParams;
    }
    
    /**
     * Gets $authParams
     * 
     * @return array $authParams Authentication parameters
     */
    public function getAuthParams()
    {
        return $this->authParams;
    }
    
    /**
     * Validate referrer
     * 
     * @return bool True if the authentication parameters is valid
     */
    abstract public function validate();
    
}
