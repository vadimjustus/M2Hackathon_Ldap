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

namespace M2Hackathon\Ldap\Exception;

use Magento\Framework\Exception\AuthenticationException;

class UnknownUserException extends AuthenticationException
{

}