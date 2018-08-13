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
use App\Utils\Generic\InMemoryDataServicesGeneric;

class MemoryRepository
{

    /**
     * @var array
     */
    protected $repositoryTupples;


    /**
     * MemoryRepository constructor.
     *
     * @param InMemoryDataServicesGeneric $inMemoryDataServicesGeneric
     * @param string $entity
     *
     * @throws \Exception
     */
    public function __construct( InMemoryDataServicesGeneric $inMemoryDataServicesGeneric, string $entity ) {

        $this -> repositoryTupples = $inMemoryDataServicesGeneric -> getDataForEntity( $entity );
    }


    public function find( int $id ) {

        foreach( $this -> repositoryTupples as $tupple ) {

            if( $tupple["id"] === $id ) {
                return new User();
            }
        }

        throw new EntityNotFoundException("Entity #".$id." isn't found");
    }


    public function findBy( array $params ): ?array {

        $arrReturn = [];

    }

}