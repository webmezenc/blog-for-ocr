<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 07/09/2018
 * Time: 20:21
 */

namespace App\Domain\Command\Post;


use App\Entity\Post;
use App\Exception\EntityNotFoundException;
use App\Exception\NotFoundException;
use App\Infrastructure\GatewayAuthenticateUser;
use App\Infrastructure\InfrastructureValidatorInterface;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class DeletePostWithActualUser extends CommandPostWithActualUser
{

    /**
     * @var RepositoryAdapterInterface
     */
    private $repository;

    /**
     * DeletePostWithActualUser constructor.
     *
     * @param GatewayAuthenticateUser $authenticateUser
     * @param InfrastructureValidatorInterface $validator
     * @param RepositoryAdapterInterface $repository
     */
    public function __construct
    (
        GatewayAuthenticateUser $authenticateUser,
        InfrastructureValidatorInterface $validator,
        RepositoryAdapterInterface $repository
    )
    {
        $this -> repository = $repository;
        parent::__construct($authenticateUser, $validator);
    }

    /**
     * @param string $slug
     *
     * @throws EntityNotFoundException
     */
    public function deletePost( string $slug ) {

        $post = $this -> repository -> findOneBy( [
            "slug" => $slug
        ]);

        $this -> repository -> remove($post);

    }
}