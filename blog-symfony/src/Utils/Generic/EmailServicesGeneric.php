<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 09:00
 */

namespace App\Utils\Generic;

use App\Exception\EmailInvalidException;
use Respect\Validation\Validator;

class EmailServicesGeneric
{

    /**
     * @param string $email
     *
     * @return bool
     *
     * @throws EmailInvalidException
     */
    static public function validateEmail( string $email ): bool {

        if( !Validator::email() -> validate( $email ) ) {
            throw new EmailInvalidException($email." isn't valid");
        }

        return true;
    }

}