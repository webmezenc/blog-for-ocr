<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/08/2018
 * Time: 11:50
 */

namespace App\Utils\Generic;

use App\Exception\FileEmptyException;
use App\Exception\FileIsNotValidJsonException;
use \App\Exception\FileNotFoundException;

class InMemoryDataServicesGeneric
{

    /**
     * @var FileServicesGeneric
     */
    private $fileServicesGeneric;


    public const IN_MEMORY = "InMemory";


    public function __construct(FileServicesGeneric $fileServicesGeneric ) {
        $this -> fileServicesGeneric = $fileServicesGeneric;
    }

    /**
     * @param string $entity
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getDataForEntity( string $entity ): array {

        try {
            $fileData = $this -> getJsonDataFileWithEntityName( $entity );

            if( empty($fileData) ) {
                throw new FileEmptyException("The file for ".$entity." is empty");
            }

            return $this -> obtainArrayFromJson( $fileData );

        } catch( \Exception $e ) {
            throw $e;
        }

    }


    /**
     * @param string $fileData
     *
     * @return array
     *
     * @throws FileIsNotValidJsonException
     */
    private function obtainArrayFromJson( string $fileData ): array {

        $arrayData = json_decode( $fileData , true );

        if( !is_array($arrayData) ) {
            throw new FileIsNotValidJsonException();
        }

        return $arrayData;

    }



    /**
     * @param string $entity
     *
     * @throws \Exception
     */
    private function getJsonDataFileWithEntityName( string $entity ) {

        $pathDataFile = self::IN_MEMORY."/".$entity.".json";

        try {
            return $this -> fileServicesGeneric -> getContentFile( $pathDataFile );
        } catch( \Exception $e ) {
            throw $e;
        }
    }
}