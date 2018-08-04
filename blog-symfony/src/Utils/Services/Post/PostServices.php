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
use App\Repository\PostRepository;
use Doctrine\ORM\EntityNotFoundException;
use PHPUnit\Runner\Exception;

class PostServices
{

    private $postRepository;

    /**
     * PostServices constructor.
     */
    public function __construct( PostRepository $postRepository )
    {
        $this -> postRepository = $postRepository;
    }


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