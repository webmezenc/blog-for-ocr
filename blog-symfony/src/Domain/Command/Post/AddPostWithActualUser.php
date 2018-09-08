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

class AddPostWithActualUser extends CommandPostWithActualUser
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

        parent::__construct($authenticateUser,$validator);
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

        $this -> isValidConditionsToExecuteActions($post);

        $post -> setDateCreate(new \DateTimeImmutable());
        $post -> setIdUser($this -> authenticateUser -> getUser());
        $post -> setSlug($this -> getSlug($post));

        $this -> postRepository -> getEntityManager() -> persist($post);
        $this -> postRepository -> getEntityManager() -> flush();

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