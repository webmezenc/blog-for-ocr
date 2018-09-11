<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 17:16
 */

namespace App\Repository\InMemory;


use App\Entity\Comments;
use App\Entity\Post;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Utils\Generic\HydratorServicesGeneric;
use App\Utils\Generic\InMemoryDataServicesGeneric;

class CommentsRepository extends MemoryRepository
{

    const ENTITY = "Comments";

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


    /**
     * @param Post $post
     * @return Comments[]
     */
    public function findCommentsPublishByPost( Post $post ) {
        return $this -> findBy([
            "id_post" => $post,
            "state" => Post::POST_PUBLISHED
        ]);
    }

}