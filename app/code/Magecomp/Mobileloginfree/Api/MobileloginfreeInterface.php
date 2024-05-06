<?php
namespace Magecomp\Mobileloginfree\Api;

/**
 * Interface Mobileloginfreeinterface
 * Magecomp\Mobileloginfree\Api
 */
interface MobileloginfreeInterface
{
    /**
     * @param string $mobileEmail
     * @param string $password
     * @return string
     */
    public function getLogin($mobileEmail,$password);

}
