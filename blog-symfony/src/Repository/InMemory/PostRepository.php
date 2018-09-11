<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 20:26
 */

namespace App\Repository\InMemory;


use App\Entity\ValueObject\OrderLimit;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Utils\Generic\HydratorServicesGeneric;
use App\Utils\Generic\InMemoryDataServicesGeneric;
use App\Utils\Generic\ObjectServicesGeneric;

class PostRepository extends MemoryRepository
{
    const ENTITY = "Post";

    /**
     * PostRepository constructor.
     *
     * @param InMemoryDataServicesGeneric $inMemoryDataServicesGeneric
     * @param HydratorServicesGeneric $hydratorServicesGeneric
     *
     * @throws \Exception
     */
    public function __construct( InMemoryDataServicesGeneric $inMemoryDataServicesGeneric, HydratorServicesGeneric $hydratorServicesGeneric ) {
        parent::__construct( $inMemoryDataServicesGeneric, $hydratorServicesGeneric, self::ENTITY );
    }



    /**
     * @param OrderLimit $orderLimit
     *
     * @return array
     *
     * @throws \App\Exception\TypeErrorException
     */
    public function getValidPostWithOrderAndLimit( OrderLimit $orderLimit ): array {

        $allPosts = $this -> findAll();

        if( count($allPosts) === 0 ) {
            return [];
        } else {
            $entities = array_slice( $allPosts, $orderLimit -> getStart(), ($orderLimit -> getStart()+$orderLimit -> getEnd()) );
            return $this -> fromObjectEntitiesToArrayEntities( $entities );
        }

    }

    /**
     * @param array $entities
     *
     * @return array
     *
     * @throws \App\Exception\TypeErrorException
     */
    private function fromObjectEntitiesToArrayEntities( array $entities ) {

        $entitiesArray = [];

        foreach( $entities as $entity ) {
            array_push( $entitiesArray,ObjectServicesGeneric::getArrayFromObject($entity) );
        }

        return $entitiesArray;

    }
}