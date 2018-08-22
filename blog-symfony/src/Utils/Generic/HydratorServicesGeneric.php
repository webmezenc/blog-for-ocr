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


    public function hydrate( string $entity, array $params ) {

        EntityServicesGeneric::isExist( $entity );

        return $this -> createInstanceAndHydrate(  $entity,  $params );
    }


    /**
     * @param string $entity
     * @param array $params
     *
     * @return object
     *
     * @throws \App\Exception\TypeErrorException
     */
    private function createInstanceAndHydrate( string $entity, array $params ) {

        $className = EntityServicesGeneric::getClassName($entity);

        $instanceObject = new $className();

        return $this -> hydrateInstanceObject($instanceObject, $params);
    }

    /**
     * @param object $instanceObject
     * @param array $params
     *
     * @return object
     *
     * @throws \App\Exception\TypeErrorException
     */
    private function hydrateInstanceObject($instanceObject, array $params)
    {
        foreach ($params as $property => $value) {

            if ($this->objectServicesGeneric->isSetter($property, $instanceObject)) {
                $setter = "set" . ucfirst($property);
                $instanceObject->$setter($value);
            }
        }

        return $instanceObject;
    }


}