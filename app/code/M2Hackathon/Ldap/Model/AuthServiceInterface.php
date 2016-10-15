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

/**
 * AuthInterface
 */
namespace M2Hackathon\Ldap\Services;

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
