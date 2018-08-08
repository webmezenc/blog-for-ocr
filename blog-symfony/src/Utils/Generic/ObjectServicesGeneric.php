<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 07/08/2018
 * Time: 14:59
 */

namespace App\Utils\Generic;


use App\Exception\TypeErrorException;

class ObjectServicesGeneric
{


    /**
     * @param $object
     *
     * @return array
     *
     * @throws TypeErrorException
     * @throws \Exception
     */
    static public function getArrayFromObject( $object ): array
    {
        if( !is_object($object) ) {
            throw new TypeErrorException("Parameter must be a valid object");
        }

        try {

            $arrPropertyReflection = self::getPropertiesWithReflexion( $object );

            return self::getParamsValuesWithGetter( $arrPropertyReflection,$object );

        } catch( \Exception $e ) {
            throw new \Exception("Error occurred when use reflection to obtain parameters value in object ".$e -> getMessage());
        }

    }





    /**
     * @param \ReflectionProperty[] $arrReflectionProperty
     *
     * @return array
     */
    static private function getArrayParamsValueFromArrayReflectionProperty( array $arrReflectionProperty ): array {

        $arrReturn = [];

        foreach( $arrReflectionProperty as $reflectionProperty ) {
            $arrReturn[ $reflectionProperty -> getName() ] = $reflectionProperty -> getValue();
        }

        return $arrReturn;
    }


    /**
     * @param \ReflectionProperty[] $arrReflectionProperty
     * @param object $object
     *
     * @return array
     */
    static private function getParamsValuesWithGetter( array $arrReflectionProperty, $object ): array {

        $arrParams = [];

        foreach( $arrReflectionProperty as $reflectionProperty ) {

            $getter = "get".ucfirst($reflectionProperty -> getName() );

            if( method_exists($object,$getter) ) {
                $arrParams[ $reflectionProperty -> getName() ] = $object -> $getter();
            }

        }

        return $arrParams;

    }


    /**
     * @param $object
     *
     * @return \ReflectionProperty[]
     *
     * @throws \ReflectionException
     */
    static private function getPropertiesWithReflexion( $object ): array {

        try {

            $reflection = new \ReflectionClass( $object );

            return $reflection -> getProperties();


        } catch( \ReflectionException $e ) {
            throw $e;
        }

    }

}