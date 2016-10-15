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

namespace M2Hackathon\Ldap\Model;

use M2Hackathon\Ldap\Exception\UnknownUserException;
use Magento\User\Model\UserValidationRules;

class User extends \Magento\User\Model\User
{
    /**
     * @var \M2Hackathon\Ldap\Model\AuthServiceInterface
     */
    protected $authService;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\User\Helper\Data $userData
     * @param \Magento\Backend\App\ConfigInterface $config
     * @param \Magento\Framework\Validator\DataObjectFactory $validatorObjectFactory
     * @param \Magento\Authorization\Model\RoleFactory $roleFactory
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\Encryption\EncryptorInterface $encryptor
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param UserValidationRules $validationRules
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\User\Helper\Data $userData,
        \Magento\Backend\App\ConfigInterface $config,
        \Magento\Framework\Validator\DataObjectFactory $validatorObjectFactory,
        \Magento\Authorization\Model\RoleFactory $roleFactory,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        UserValidationRules $validationRules,
        \M2Hackathon\Ldap\Model\AuthServiceInterface $authService,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $userData,
            $config,
            $validatorObjectFactory,
            $roleFactory,
            $transportBuilder,
            $encryptor,
            $storeManager,
            $validationRules,
            $resource,
            $resourceCollection,
            $data
        );

        $this->authService = $authService;
    }

    /**
     * @return AuthServiceInterface
     */
    protected function getAuthService()
    {
        return $this->authService;
    }

    /**
     * Authenticate user name and password and save loaded record
     *
     * @param string $username
     * @param string $password
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function authenticate($username, $password)
    {
        try {
            $this->_eventManager->dispatch(
                'admin_user_authenticate_before',
                ['username' => $username, 'user' => $this]
            );

            $result = $this->getAuthService()->authenticate($username, $password);

            // TODO: load the user data from ldap server
            $this->loadByUsername('admin');

            $this->_eventManager->dispatch(
                'admin_user_authenticate_after',
                ['username' => $username, 'password' => $password, 'user' => $this, 'result' => $result]
            );

            return $result;
        } catch (UnknownUserException $exception) {
            return parent::authenticate($username, $password);
        }
    }
}