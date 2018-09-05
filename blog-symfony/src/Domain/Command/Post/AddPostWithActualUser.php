<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 31/08/2018
 * Time: 19:01
 */

namespace App\Domain\Command\Post;

use App\Entity\Post;
use App\Entity\User;
use App\Exception\EntityParametersErrorException;
use App\Exception\UnhautorizedException;
use App\Infrastructure\GatewayAuthenticateUser;
use App\Infrastructure\InfrastructureValidatorInterface;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Utils\Generic\SlugServices;

class AddPostWithActualUser
{

    /**
     * @var InfrastructureValidatorInterface
     */
    private $validator;

    /**
     * @var GatewayAuthenticateUser
     */
    private $authenticateUser;


    /**
     * @var RepositoryAdapterInterface
     */
    private $postRepository;


    /**
     * AddPostWithActualUser constructor.
     * @param InfrastructureValidatorInterface $validator
     */
    public function __construct(
        InfrastructureValidatorInterface $validator,
        GatewayAuthenticateUser $authenticateUser,
        RepositoryAdapterInterface $postRepository
    )
    {
        $this -> authenticateUser = $authenticateUser;
        $this -> postRepository = $postRepository;
        $this -> validator = $validator;
    }

    /**
     * @param Post $post
     *
     * @return Post
     *
     * @throws EntityParametersErrorException
     * @throws UnhautorizedException
     */
    public function addPost( Post $post ): Post {

        if( !$this -> authenticateUser -> getUser() instanceof User ) {
            throw new UnhautorizedException("User must be authenticate to add post");
        }

        if( !$this -> validator -> validate($post) ) {
            throw new EntityParametersErrorException("Your Post entity parameters isn't a valid : ".implode(", ",$this -> validator -> getErrors()));
        }

        $post -> setDateCreate(new \DateTimeImmutable());
        $post -> setIdUser($this -> authenticateUser -> getUser());
        $post -> setSlug($this -> getSlug($post));

        $this -> postRepository -> persist($post);
        $this -> postRepository -> flush();

        return $post;
    }

    /**
     * @param Post $post
     * @return string
     */
    private function getSlug( Post $post ): string {
        return SlugServices::slugify( $post -> getTitle() )."-".date('Ymd');
    }
}