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
    const XML_CONFIG_LDAP_ENABLE = 'admin/ldap/enable';
    const XML_CONFIG_LDAP_HOST = 'admin/ldap/host';
    const XML_CONFIG_LDAP_PORT = 'admin/ldap/port';
    const XML_CONFIG_LDAP_USER = 'admin/ldap/user';
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
    private $connection = null;
    
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

        $options = array(
            'host'              => $this->getHost(),
            'port'              => $this->getPort(),
            'bindRequiresDn'    => true,
            'username'          => $this->getUser(),
            'baseDn'            => $this->getBaseDs(),
        );
        
        $this->connection = new \Zend_Ldap($options);
    }

    /**
     * Search node in ldap server.
     * 
     * @param $filter
     * @param null|array $characteristics
     */
    public function search($filter, $characteristics = null)
    {
        $this->connection->bind();

        $searchResult = ldap_search($this->getConnection(), $this->getBaseDs(), $filter, $characteristics);
        
        $result = ldap_get_entries($this->getConnection(), $searchResult);
        
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
        $acctname = $this->connection->getCanonicalAccountName(
            $name, \Zend_Ldap::ACCTNAME_FORM_USERNAME
        );
        
        $this->logger->notice($acctname);
    }

    /**
     * Check if the module is enabled.
     * 
     * @return boolean
     */
    protected function getModuleEnabled() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        return $this->scopeConfig->getValue(self::XML_CONFIG_LDAP_ENABLE, $storeScope);
    }
    /**
     * Get Address to Ldap Server.
     * 
     * @return String
     */
    protected function getHost() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        return $this->scopeConfig->getValue(self::XML_CONFIG_LDAP_HOST, $storeScope);
    }

    /**
     * Get Ldap Port.
     * 
     * @return String
     */
    protected function getPort() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $port = $this->scopeConfig->getValue(self::XML_CONFIG_LDAP_PORT, $storeScope);
        
        if (empty($port)) {
            $port = self::DEFAULT_PORT;
        }

        return $port;
    }

    /**
     * Get Base Distinguished Names.
     * 
     * @return String
     */
    protected function getBaseDs() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $baseDs = $this->scopeConfig->getValue(self::XML_CONFIG_LDAP_DN, $storeScope);

        return $baseDs;
    }
    /**
     * Get Base Distinguished Names.
     *
     * @return String
     */
    protected function getUser() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $baseDs = $this->scopeConfig->getValue(self::XML_CONFIG_LDAP_USER, $storeScope);

        return $baseDs;
    }
}