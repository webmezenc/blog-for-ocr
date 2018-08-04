<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 04/08/2018
 * Time: 12:51
 */

namespace App\Application\Query;


use App\Entity\Post;
use App\Entity\ValueObject\OrderLimit;
use App\Exception\PostServicesException;
use App\Infrastructure\Repository\RepositoryAdapterInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Repository\RepositoryFactory;

class PostQuery
{

    private $postRepository;

    /**
     * PostQuery constructor.
     * @param RepositoryAdapterInterface $postRepository
     */
    public function __construct( RepositoryAdapterInterface $postRepository )
    {
        $this -> repository = $repository;
    }

    /**
     * @param string $slug
     * @return Post
     */

    public function gePublishPostBySlug( string $slug ): Post
    {
        $findPost = $this -> postRepository -> findOneBy( array("slug" => $slug));

        if( is_null($findPost) ) {
            throw new EntityNotFoundException("Post identified by ".$slug." isn't found");
        }

        if( $findPost -> getState() !== Post::POST_PUBLISHED ) {
            throw new PostServicesException("This post isn't published");
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