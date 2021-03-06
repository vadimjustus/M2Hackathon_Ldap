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

interface AuthServiceInterface
{
    /**
     * Authenticate if an User is allowed to login.
     *
     * @param String $userName
     * @param String $password
     * @return bool
     */
    public function authenticate($userName, $password);

    /**
     * Get the Role for the given User by Id.
     *
     * @param int $userId
     * @return int
     */
    public function getRole($userId);
}
