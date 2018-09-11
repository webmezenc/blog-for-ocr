<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 31/08/2018
 * Time: 19:01
 */

namespace App\Domain\Command\Post;

use App\Entity\Post;
use App\Infrastructure\GatewayAuthenticateUser;
use App\Infrastructure\InfrastructureValidatorInterface;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Utils\Generic\ObjectServicesGeneric;
use App\Utils\Generic\SlugServices;

class EditPostWithActualUser extends CommandPostWithActualUser
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
     * @return Post
     *
     * @throws \App\Exception\EntityParametersErrorException
     * @throws \App\Exception\UnhautorizedException
     */
    public function editPost( Post $post ): Post {

        $this -> isValidConditionsToExecuteActions($post);

        $this -> postRepository -> getEntityManager() -> flush();

        return $post;
    }


}