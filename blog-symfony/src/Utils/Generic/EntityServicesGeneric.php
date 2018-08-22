<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 14/08/2018
 * Time: 20:55
 */

namespace App\Utils\Generic;


use App\Exception\EntityNotFoundException;

class EntityServicesGeneric
{

    /**
     * @param string $entityName
     **
     * @throws EntityNotFoundException
     */
    static public function isExist( string $entityName ) {

        self::isValidClassName($entityName, self::getClassName($entityName) );

        return true;
    }

    /**
     * @param string $entityName
     *
     * @param $className
     *
     * @throws EntityNotFoundException
     */
    private static function isValidClassName(string $entityName, $className): void
    {
        if (!class_exists($className)) {
            throw new EntityNotFoundException("Entity " . $entityName . " isn't exist");
        }
    }

    /**
     * @param string $entityName
     * @return string
     */
    public static function getClassName(string $entityName): string
    {
        return $className = "\App\Entity\\" . $entityName;
    }


}