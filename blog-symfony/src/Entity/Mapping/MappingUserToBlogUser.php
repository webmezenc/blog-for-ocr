<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 22/08/2018
 * Time: 17:07
 */

namespace App\Entity\Mapping;


use App\Entity\User;
use App\Exception\ParameterInvalidException;
use App\Security\User\BlogUser;

class MappingUserToBlogUser
{

    const USER_LEVEL_TO_BLOGUSER_ROLE = [
        User::USER_LEVEL => "ROLE_USER",
        User::ADMIN_LEVEL => "ROLE_ADMIN"
    ];


    /**
     * @param User $user
     *
     * @return BlogUser
     *
     * @throws ParameterInvalidException
     */
    static public function mapping( User $user ): BlogUser {

        $userRole = self::levelUserToRole( $user -> getLevel() );

        return new BlogUser( [$userRole], $user -> getPassword(), md5(uniqid('', true)), $user -> getEmail() );

    }

    /**
     * @param int $level
     *
     * @return string
     *
     * @throws ParameterInvalidException
     */
    static private function levelUserToRole( int $level ): string {

        if( !key_exists($level,self::USER_LEVEL_TO_BLOGUSER_ROLE) ) {
            throw new ParameterInvalidException("Level ".$level." isn't valid");
        }

        return self::USER_LEVEL_TO_BLOGUSER_ROLE[$level];
    }
}