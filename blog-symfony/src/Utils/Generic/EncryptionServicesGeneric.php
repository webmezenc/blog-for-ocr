<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 22/08/2018
 * Time: 13:17
 */

namespace App\Utils\Generic;


class EncryptionServicesGeneric
{


    /**
     * @param string $hash
     * @param string $password
     *
     * @return bool
     */
    static public function verifyPassword(string $hash, string $password): bool {
        return $hash === self::passwordEncrypt($password);
    }

    /**
     * @param string $password
     * @return string
     */
    static public function passwordEncrypt(string $password) {
        return hash("sha256", $password);
    }
}