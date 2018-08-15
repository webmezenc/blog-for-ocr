<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 15/08/2018
 * Time: 19:48
 */

namespace App\Utils\Generic;


class ArrayServicesGeneric
{


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