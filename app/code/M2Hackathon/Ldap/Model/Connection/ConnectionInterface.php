<?php
/**
 * Created by PhpStorm.
 * User: deiserh
 * Date: 15/10/16
 * Time: 11:47
 */
namespace M2Hackathon\Ldap\Model\Connection;

interface ConnectionInterface
{
    
    public function search($filter, $characteristics);
}