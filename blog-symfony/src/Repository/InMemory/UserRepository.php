<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 13/08/2018
 * Time: 11:01
 */

namespace App\Repository\InMemory;


use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Infrastructure\Repository\Entity\UserRepositoryAdapterInterface;
use App\Utils\Generic\HydratorServicesGeneric;
use App\Utils\Generic\InMemoryDataServicesGeneric;

class UserRepository extends MemoryRepository implements RepositoryAdapterInterface, UserRepositoryAdapterInterface
{

    const ENTITY = "User";

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