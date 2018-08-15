<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 13/08/2018
 * Time: 11:07
 */

namespace App\Repository\InMemory;


use App\Entity\User;
use App\Exception\EntityNotFoundException;
use App\Utils\Generic\HydratorServicesGeneric;
use App\Utils\Generic\InMemoryDataServicesGeneric;

class MemoryRepository
{

    /**
     * @var array
     */
    protected $repositoryTupples;


    /**
     * @var HydratorServicesGeneric
     */
    protected $hydratorServicesGeneric;


    /**
     * @var string
     */
    private $entity;


    /**
     * MemoryRepository constructor.
     *
     * @param InMemoryDataServicesGeneric $inMemoryDataServicesGeneric
     * @param HydratorServicesGeneric $hydratorServicesGeneric
     * @param string $entity
     *
     * @throws \Exception
     */
    public function __construct( InMemoryDataServicesGeneric $inMemoryDataServicesGeneric, HydratorServicesGeneric $hydratorServicesGeneric, string $entity ) {

        $this -> repositoryTupples = $inMemoryDataServicesGeneric -> getDataForEntity( $entity );
        $this -> hydratorServicesGeneric = $hydratorServicesGeneric;
        $this -> entity = $entity;
    }

    /**
     * @param int $id
     *
     * @return mixed
     *
     * @throws EntityNotFoundException
     */
    public function find( int $id ) {

        return $this -> findOneBy( array("id" => $id ));

    }


    /**
     * @param array $params
     * @return array|null
     */
    public function findBy( array $params ): ?array {

        return $this -> searchInTuppleWithParameters( $params );
    }


    /**
     * @param array $params
     *
     * @return object
     *
     * @throws EntityNotFoundException
     */
    public function findOneBy( array $params ) {
        $find = $this -> searchInTuppleWithParameters( $params );

        if( is_null($find) ) {
            throw new EntityNotFoundException("Entity isn't found");
        } else {
            return current($find);
        }
    }


    /**
     * @param array $params
     *
     * @return array|null
     */
    private function searchInTuppleWithParameters( array $params ): ?array {

        $arrReturn = [];

        foreach( $this -> repositoryTupples as $tupple ) {

            $entityInTupple = $this -> searchInTupple($params, $tupple );

            if( is_object($entityInTupple) ) {
                $arrReturn[] = $entityInTupple;
            }

        }

        return count($arrReturn) === 0 ? null : $arrReturn;

    }

    /**
     * @param array $params
     * @param $tupple
     *
     * @return object
     */
    private function searchInTupple(array $params, $tupple )
    {
        foreach ($params as $key => $value) {

            if (key_exists($key, $tupple)) {

                if( $tupple[$key] === $value ) {
                    return $this -> hydratorServicesGeneric->hydrate($this->entity, $tupple);
                }

            }

        }
    }




}