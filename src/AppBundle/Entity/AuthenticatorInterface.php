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
     * @param array $authParams Authentication parameters to check
     */
    public function __construct(array $authParams);
    
    /**
     * Gets $authParams
     * 
     * @return array $authParams Authentication parameters
     */
    public function getAuthParams();
    
    /**
     * Validate referrer authentication parameters that was passed to the constructor
     * 
     * @return bool 
     */
    public function validate();
    
}
