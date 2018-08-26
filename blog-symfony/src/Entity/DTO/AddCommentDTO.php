<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 20:12
 */

namespace App\Entity\DTO;


use App\Infrastructure\GatewayAuthenticateUser;
use App\Infrastructure\InfrastructureFormBuilderCollectionInterface;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;

class AddCommentDTO
{
    /**
     * @var InfrastructureFormBuilderCollectionInterface
     */
    public $formbuildercollection;

    /**
     * @var GatewayAuthenticateUser
     */
    public $gatewayAuthenticateUser;

    /**
     * @var RepositoryAdapterInterface
     */
    public $postRepository;

    /**
     * @var string
     */
    public $slugPost;

}