<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 13/08/2018
 * Time: 11:58
 */

namespace App\Utils\Generic;

use App\Entity\User;

class HydratorServicesGeneric
{
    static public function hydrate( string $entity, array $params ) {
        return new User();
    }


}