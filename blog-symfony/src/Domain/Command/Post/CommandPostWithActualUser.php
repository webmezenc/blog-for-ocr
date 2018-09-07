<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 07/09/2018
 * Time: 15:42
 */

namespace App\Domain\Command\Post;


use App\Entity\Post;
use App\Entity\User;
use App\Infrastructure\GatewayAuthenticateUser;
use App\Infrastructure\InfrastructureValidatorInterface;
use App\Exception\EntityParametersErrorException;
use App\Exception\UnhautorizedException;


class CommandPostWithActualUser
{

    /**
     * @var GatewayAuthenticateUser
     */
    private $authenticateUser;

    /**
     * @var InfrastructureValidatorInterface
     */
    private $validator;


    /**
     * CommandPostWithActualUser constructor.
     *
     * @param GatewayAuthenticateUser $authenticateUser
     * @param InfrastructureValidatorInterface $validator
     */
    public function __construct( GatewayAuthenticateUser $authenticateUser, InfrastructureValidatorInterface $validator )
    {
        $this -> authenticateUser = $authenticateUser;
        $this -> validator = $validator;
    }


    /**
     * @param Post $post
     *
     * @throws EntityParametersErrorException
     * @throws UnhautorizedException
     */
    public function isValidConditionsToExecuteActions( Post $post ) {

        if( !$this -> authenticateUser -> getUser() instanceof User ) {
            throw new UnhautorizedException("User must be authenticate");
        }

        if( !$this -> validator -> validate($post) ) {
            throw new EntityParametersErrorException("Your Post entity parameters isn't a valid : ".implode(", ",$this -> validator -> getErrors()));
        }

    }
}