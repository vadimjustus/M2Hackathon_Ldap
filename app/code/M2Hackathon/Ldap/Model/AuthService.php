<?php
/** NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @author    Vadim Justus <v.justus@techdivision.com>
 * @author    Harald Deiser <h.deiser@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/M2Hackathon_Ldap
 * @link      http://www.techdivision.com
 */

use \M2Hackathon\Ldap\Model\AuthServiceInterface;

class AuthService implements AuthServiceInterface 
{
    const XML_CONFIG_LDAP_ADDRESS = 'admin/ldap/address';
    const XML_CONFIG_LDAP_PORT = 'admin/ldap/port';

    protected $scopeConfig;

    /**
     * AuthService constructor.
     * @param \Magento\Backend\App\ConfigInterface $scopeConfig
     */
    public function __construct(\Magento\Backend\App\ConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function authenticate($userName, $password) {
     // TODO: Implement authenticate() method.
    }
    
    public function getRole($userId) {
     // TODO: Implement getRole() method.
    }
    
    protected function getAddress() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        
        return $this->scopConfig->getValue(self::XML_CONFIG_LDAP_ADDRESS, $storeScope);
    }
    
    protected function getPort() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        return $this->scopConfig->getValue(self::XML_CONFIG_LDAP_ADDRESS, $storeScope);
    }
}