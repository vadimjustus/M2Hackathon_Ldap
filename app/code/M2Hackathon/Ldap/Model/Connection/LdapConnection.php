<?php
/**
 * Created by PhpStorm.
 * User: deiserh
 * Date: 15/10/16
 * Time: 11:46
 */
namespace M2Hackathon\Ldap\Model\Connection;

use \M2Hackathon\Ldap\Model\Connection\ConnectionInterface;

class LdapConnection implements ConnectionInterface 
{
    const XML_CONFIG_LDAP_ADDRESS = 'admin/ldap/address';
    const XML_CONFIG_LDAP_PORT = 'admin/ldap/port';
    const XML_CONFIG_LDAP_DN = 'admin/ldap/baseDn';
    const DEFAULT_PORT = '389';
    
    private $connection;
    
    protected $scopeConfig;
    protected $logger;
    public function __construct(
        \Magento\Backend\App\ConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
        
        $this->connection = ldap_connect($this->getAddress() . ':' . $this->getPort());
    }

    public function search($filter, $characteristics = null)
    {
        $login = ldap_bind($this->connection);
        $searchResult = ldap_search($this->connection, $this->getBaseDs(), $filter, $characteristics);
        
        $result = ldap_get_entries($this->connection, $searchResult);
        
        $this->logger->info($result);
    }

    protected function getAddress() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        return $this->scopeConfig->getValue(self::XML_CONFIG_LDAP_ADDRESS, $storeScope);
    }

    protected function getPort() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $port = $this->scopeConfig->getValue(self::XML_CONFIG_LDAP_PORT, $storeScope);
        
        if (empty($port)) {
            $port = self::DEFAULT_PORT;
        }

        return $port;
    }
    
    protected function getBaseDs() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $baseDs = $this->scopeConfig->getValue(self::XML_CONFIG_LDAP_DN, $storeScope);

        return $baseDs;
    }
}