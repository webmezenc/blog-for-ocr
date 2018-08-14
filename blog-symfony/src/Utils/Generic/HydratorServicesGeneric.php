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

    /**
     * @var ObjectServicesGeneric
     */
    private $objectServicesGeneric;

    /**
     * HydratorServicesGeneric constructor.
     *
     * @param ObjectServicesGeneric $objectServicesGeneric
     */
    public function __construct( ObjectServicesGeneric $objectServicesGeneric ) {
        $this -> objectServicesGeneric = $objectServicesGeneric;
    }


    static public function hydrate( string $entity, array $params ) {

        EntityServicesGeneric::isExist( $entity );

        return new User();
    }


    /**
     * @param string $entity
     * @param array $params
     *
     * @return
     */
    static private function hydrateWithReflexion( string $entity, array $params ) {

        $className = EntityServicesGeneric::getClassName($entity);


    }


}