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
    /**
     * Constants to load configuration and defined default port.
     */
    const XML_CONFIG_LDAP_ADDRESS = 'admin/ldap/address';
    const XML_CONFIG_LDAP_PORT = 'admin/ldap/port';
    const XML_CONFIG_LDAP_DN = 'admin/ldap/baseDn';
    const DEFAULT_PORT = '389';

    /**
     * @TODO Config for ds and attribute
     */
    const CONFIG_NAME_DS = 'cn=';
    const CONFIG_PASSWOR_attribute = 'password';

    /**
     * Connection to Ldap Server.
     * 
     * @var resource
     */
    private $connection;
    
    protected $scopeConfig;
    protected $logger;

    /**
     * LdapConnection constructor.
     * 
     * @param \Magento\Backend\App\ConfigInterface $scopeConfig
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Backend\App\ConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
        
        $this->connection = ldap_connect($this->getAddress() . ':' . $this->getPort());
    }

    /**
     * Search node in ldap server.
     * 
     * @param $filter
     * @param null|array $characteristics
     */
    public function search($filter, $characteristics = null)
    {
        $login = ldap_bind($this->connection);
        $searchResult = ldap_search($this->connection, $this->getBaseDs(), $filter, $characteristics);
        
        $result = ldap_get_entries($this->connection, $searchResult);
        
        $this->logger->info($result);
    }

    /**
     * Authenticate the user against ldap server.
     * 
     * @param String $name
     * @param String $password
     * @return boolean
     */
    public function authenticate($name, $password)
    {
        $result = ldap_compare($this->connection, self::CONFIG_NAME_DS . $name . ',', 
            $this->getBaseDs(), self::CONFIG_PASSWOR_attribute, $password);

        if ($result === -1) {
            $this->logger->debug(ldap_err2str());
        }

        return $result;
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