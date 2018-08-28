<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 02/08/2018
 * Time: 14:28
 */

namespace App\Utils\Services\Post;


use App\Entity\Post;
use App\Entity\ValueObject\OrderLimit;
use App\Exception\PostServicesException;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Repository\PostRepository;
use App\Exception\EntityNotFoundException;
use App\Exception\InvalidStateException;

class PostServices
{

    private $postRepository;

    /**
     * PostServices constructor.
     * @param RepositoryAdapterInterface $postRepository
     */
    public function __construct( RepositoryAdapterInterface $postRepository )
    {
        $this -> postRepository = $postRepository;
    }


    /**
     * @param string $slug
     *
     * @return Post
     *
     * @throws EntityNotFoundException
     * @throws InvalidStateException
     */
    public function getPublishPostBySlug( string $slug ): Post
    {

        $findPost = $this -> postRepository -> findOneBy( array( "slug" => $slug ));

        if( is_null($findPost) ) {
            throw new EntityNotFoundException("Post identified by ".$slug." isn't found");
        }

        if( $findPost -> getState() !== Post::POST_PUBLISHED ) {
            throw new InvalidStateException("This post isn't published");
        }

        return $findPost;

    }


    /**
     * @param int $start
     * @param int $postNumber
     *
     * @return array
     *
     * @throws PostServicesException
     */
    public function getListPost( int $start = 0, int $postNumber = 10 )
    {
        $orderLimit = new OrderLimit();
        $orderLimit -> setStart( $start );
        $orderLimit -> setEnd( $postNumber );

        try {

            $postList = $this -> postRepository -> getValidPostWithOrderAndLimit( $orderLimit );

            return $postList;

        } catch( \Exception $e ) {
            throw new PostServicesException("Error has occurred when retrieve post list : ".$e -> getMessage());
        }

    }



}