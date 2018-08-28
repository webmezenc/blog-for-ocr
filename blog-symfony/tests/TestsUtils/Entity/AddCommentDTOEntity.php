<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 27/08/2018
 * Time: 12:40
 */

namespace App\Tests\TestsUtils\Entity;


use App\Entity\DTO\AddCommentDTO;
use App\Infrastructure\Gateway\AuthenticateUser\AuthenticateUserFactory;
use App\Infrastructure\InfrastructureFormBuilderCollectionInterface;
use App\Infrastructure\Repository\RepositoryFactory;
use Psr\Container\ContainerInterface;

class AddCommentDTOEntity
{
    static public function getDTO( ContainerInterface $container, InfrastructureFormBuilderCollectionInterface $formbuildercollection, string $slug  ): AddCommentDTO {

    $AddCommentDTO = new AddCommentDTO();
    $AddCommentDTO -> formbuildercollection = $formbuildercollection;
    $AddCommentDTO -> slugPost = $slug;

    $RepositoryFactory = new RepositoryFactory($container);
    $PostRepository = $RepositoryFactory -> create("Post","inMemory");
    $AddCommentDTO -> postRepository = $PostRepository;

    $gatewayAuthenticateUserFactory = new AuthenticateUserFactory( $container );
    $AddCommentDTO -> gatewayAuthenticateUser = $gatewayAuthenticateUserFactory -> create("inMemory");

    return $AddCommentDTO;
}
}