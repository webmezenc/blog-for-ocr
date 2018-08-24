<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/08/2018
 * Time: 11:50
 */

namespace App\Utils\Generic;

use App\Exception\EntityNotFoundException;
use App\Exception\FileEmptyException;
use App\Exception\FileIsNotValidJsonException;
use \App\Exception\FileNotFoundException;
use App\Exception\ParameterIsNotFoundException;

class InMemoryDataServicesGeneric
{

    /**
     * @var FileServicesGeneric
     */
    private $fileServicesGeneric;

    /**
     * @var HydratorServicesGeneric
     */
    private $hydratorServicesGeneric;


    public const IN_MEMORY = "InMemory";


    public function __construct(FileServicesGeneric $fileServicesGeneric, HydratorServicesGeneric $hydratorServicesGeneric ) {
        $this -> fileServicesGeneric = $fileServicesGeneric;
        $this -> hydratorServicesGeneric = $hydratorServicesGeneric;
    }

    /**
     * @param array $params
     * @param array $tupples
     * @param string $entityName
     *
     * @return array|null
     */
    public function searchInTuppleWithParametersAndHydrateEntityIfEntityIsDefined( array $params, array $tupples, string $entityName = null ): ?array {

        $arrReturn = [];

        foreach( $tupples as $tupple ) {

            $entityInTupple = $this -> searchInTuppleAndHydrateEntityIfEntityIsDefined($params, $tupple, $entityName );

            if( !empty($entityInTupple) ) {
                $arrReturn[] = $entityInTupple;
            }

        }

        return count($arrReturn) === 0 ? null : $arrReturn;

    }


    /**
     * @param array $params
     * @param array $tupple
     * @param string $entityName
     *
     * @return mixed
     */
    private function searchInTuppleAndHydrateEntityIfEntityIsDefined(array $params, array $tupple, string $entityName = null  )
    {
        foreach ($params as $key => $value) {

            if (key_exists($key, $tupple)) {

                if( $tupple[$key] === $value ) {

                    if( !is_null($entityName) ) {
                        return $this -> hydratorServicesGeneric->hydrate($entityName, $tupple);
                    } else {
                        return $tupple;
                    }

                }

            }

        }
    }




    /**
     * @param array $params
     * @param array $tupples
     *
     * @return array
     *
     * @throws ParameterIsNotFoundException
     */
    public function addDataInTuppleWithAutoIncrement( array $params, array $tupples ): array {

        return $this -> autoIncrementId( $params, $tupples );

    }

    /**
     * @param int $id
     * @param array $dataTupples
     *
     * @return array
     */
    public function deleteTuppleWithId( int $id, array $dataTupples ): array {

        $findTupple = $this -> searchInTuppleWithParametersAndHydrateEntityIfEntityIsDefined( array("id" => $id), $dataTupples );

        if( is_null($findTupple) ) {
            throw new EntityNotFoundException("Entity identified by #".$id." isn't found");
        }

        return ArrayServicesGeneric::deleteElementInArray( $dataTupples, current($findTupple) );
    }

    /**
     * @param array $params
     * @param array $tupples
     *
     * @return array
     *
     * @throws ParameterIsNotFoundException
     */
    private function autoIncrementId( array $params, array $tupples ) {

        end($tupples );

        if( !key_exists("id", current($tupples) ) ) {
            throw new ParameterIsNotFoundException("Id isn't found on last tupple, please verify your data");
        }

        $lastTupple = current($tupples);

        array_push( $tupples, array_merge( $params, ["id" => $lastTupple["id"]+1 ] ) );

        return $tupples;
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