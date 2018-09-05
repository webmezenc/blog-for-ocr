<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 20:39
 */

namespace App\Domain\Command\Comment;

use App\Entity\Comments;
use App\Entity\Post;
use App\Entity\User;
use App\Exception\EntityNotFoundException;
use App\Infrastructure\GatewayAuthenticateUser;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Repository\PostRepository;
use App\Utils\Services\Comment\CommentServices;

class AddCommentWithUserAndPost
{

    const REQUIRED_PARAMS = ["slug"];

    /**
     * @var GatewayAuthenticateUser
     */
    private $gatewayAuthenticateUser;

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var CommentServices
     */
    private $commentServices;

    /**
     * AddCommentWithUserAndPost constructor.
     *
     * @param GatewayAuthenticateUser $gatewayAuthenticateUser
     * @param RepositoryAdapterInterface $postRepository
     * @param CommentServices $commentServices
     */
    public function __construct( GatewayAuthenticateUser $gatewayAuthenticateUser,
                                 RepositoryAdapterInterface $postRepository,
                                 CommentServices $commentServices)
    {
        $this -> gatewayAuthenticateUser = $gatewayAuthenticateUser;
        $this -> postRepository = $postRepository;
        $this -> commentServices = $commentServices;
    }


    /**
     * @param string $slug
     * @param Comments $comments
     * @return bool
     * @throws EntityNotFoundException
     */
    public function addComment( string $slug, Comments $comments ): bool
    {
        if( $this -> gatewayAuthenticateUser -> getUser() instanceof User ) {

            $Post = $this -> postRepository -> findOneBy( [
                "slug" => $slug
            ]);

            if( !$Post instanceof Post ) {
                throw new EntityNotFoundException("A post referenced by the slug ".$slug." isn't found");
            }


            $comments = $this -> hydrateComment( $Post, $comments );
            $comments = $this -> commentServices -> addComment( $comments );

            return $this->commentPersistance($comments);

        }
    }

    /**
     * @param Post $post
     * @param Comments $comments
     *
     * @return Comments
     * @throws \Exception
     */
    private function hydrateComment( Post $post, Comments $comments ): Comments {

        $comments -> setIdPost( $post );
        $comments -> setIdUser( $this -> gatewayAuthenticateUser -> getUser() );
        $comments -> setDateCreate( new \DateTimeImmutable() );
        $comments -> setState(0);

        return $comments;
    }

    /**
     * @param Comments $comments
     * @return bool
     */
    private function commentPersistance(Comments $comments): bool
    {
        if ($comments instanceof Comments) {

            try {
                $this->postRepository->getEntityManager()->flush();
                return true;
            } catch (\Exception $e) {
                return false;
            }

        }

        return false;
    }
}