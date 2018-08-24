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
        return password_verify($password,$hash);
    }

    /**
     * @param string $password
     * @return string
     */
    static public function passwordEncrypt(string $password) {
        return password_hash($password,PASSWORD_DEFAULT);
    }
}