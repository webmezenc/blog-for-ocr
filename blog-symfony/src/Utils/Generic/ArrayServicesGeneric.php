<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 15/08/2018
 * Time: 19:48
 */

namespace App\Utils\Generic;


use App\Exception\ParameterIsNotFoundException;

class ArrayServicesGeneric
{

    /**
     * @param array $keyList
     * @param array $arrayToSearch
     *
     * @return bool
     *
     * @throws ParameterIsNotFoundException
     */
    static public function allKeysAreInArray( array $keyList, array $arrayToSearch ) {

        foreach( $keyList as $key ) {

            if( !key_exists($key,$arrayToSearch) ) {
                throw new ParameterIsNotFoundException("Key ".$key." isn't found in array");
            }

        }

        return true;
    }


    /**
     * @param array $arrInput
     * @param mixed $elementToDelete
     *
     * @return array
     */
    static public function deleteElementInArray( array $arrInput, $elementToDelete ): array {

        foreach( $arrInput as $key => $element ) {

            if( $element === $elementToDelete ) {
                unset($arrInput[$key]);
            }

        }

        return $arrInput;

    }
}