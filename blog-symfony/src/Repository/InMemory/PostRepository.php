<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 20:26
 */

namespace App\Repository\InMemory;


use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Utils\Generic\HydratorServicesGeneric;
use App\Utils\Generic\InMemoryDataServicesGeneric;

class PostRepository extends MemoryRepository implements RepositoryAdapterInterface
{
    const ENTITY = "Post";

    /**
     * UserRepository constructor.
     * @param InMemoryDataServicesGeneric $inMemoryDataServicesGeneric
     * @param HydratorServicesGeneric $hydratorServicesGeneric
     *
     * @throws \Exception
     */
    public function __construct( InMemoryDataServicesGeneric $inMemoryDataServicesGeneric, HydratorServicesGeneric $hydratorServicesGeneric ) {
        parent::__construct( $inMemoryDataServicesGeneric, $hydratorServicesGeneric, self::ENTITY );
    }
}