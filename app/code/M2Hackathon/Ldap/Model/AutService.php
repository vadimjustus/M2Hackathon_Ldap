<?php
/**
 * Copyright (c) 2016 TechDivision GmbH
 * All rights reserved
 *
 * This product includes proprietary software developed at TechDivision GmbH, Germany
 * For more information see http://www.techdivision.com/
 *
 * To obtain a valid license for using this software please contact us at
 * license@techdivision.com
 */

use \M2Hackathon\Ldap\Services\AuthServiceInterface;

class AuthService implements AuthServiceInterface 
{
    const XML_CONFIG_LDAP_ADDRESS = 'admin/ldap/address';
    const XML_CONFIG_LDAP_PORT = 'admin/ldap/port';
    protected $scopConfig;
    
    public function __construct(\Magento\Backend\App\ConfigInterface $scopConfig)
    {
        $this->scopConfig = $scopConfig;
    }

    public function authenticate($userName, $password) {
     // TODO: Implement authenticate() method.
    }
    
    public function getRole($userId) {
     // TODO: Implement getRole() method.
    }
    
    protected function getAddress() {
        $storeScop = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        
        return $this->scopConfig->getValue(self::XML_CONFIG_LDAP_ADDRESS, $storeScop);
    }
    
    protected function getPort() {
        $storeScop = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        return $this->scopConfig->getValue(self::XML_CONFIG_LDAP_ADDRESS, $storeScop);
    }
}