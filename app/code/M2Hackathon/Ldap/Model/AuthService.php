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

use \M2Hackathon\Ldap\Model\AuthServiceInterface;

class AuthService implements AuthServiceInterface 
{
    /**
     * Configuration paths
     */
    const XML_CONFIG_LDAP_ADDRESS = 'admin/ldap/address';
    const XML_CONFIG_LDAP_PORT = 'admin/ldap/port';

    /**
     * @var \Magento\Backend\App\ConfigInterface
     */
    protected $scopeConfig;
    
    public function __construct(
        \Magento\Backend\App\ConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->scopeConfig = $scopeConfig;
        $logger->info($this->getAddress());
    }

    public function authenticate($userName, $password) {
     // TODO: Implement authenticate() method.
    }
    
    public function getRole($userId) {
     // TODO: Implement getRole() method.
    }
    
    protected function getAddress() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        
        return $this->scopeConfig->getValue(self::XML_CONFIG_LDAP_ADDRESS, $storeScope);
    }
    
    protected function getPort() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        return $this->scopeConfig->getValue(self::XML_CONFIG_LDAP_ADDRESS, $storeScope);
    }
}