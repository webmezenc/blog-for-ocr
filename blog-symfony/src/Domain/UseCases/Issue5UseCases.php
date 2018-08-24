<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 17:13
 */

namespace App\Domain\UseCases;

use App\Entity\Mapping\MappingUserToBlogUser;
use App\Entity\User;
use App\Exception\EntityAlreadyExistException;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\InfrastructureFormBuilderCollectionInterface;
use App\Infrastructure\InfrastructureFormBuilderInterface;
use App\Infrastructure\InfrastructureMailerInterface;
use App\Infrastructure\InfrastructureRepositoryFactoryInterface;
use App\Infrastructure\Mailer\Mailer;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Repository\UserRepository;
use App\Utils\Generic\EncryptionServicesGeneric;
use App\Utils\Services\User\UserServices;

class Issue5UseCases implements UseCasesLogicInterface
{

    /**
     * @var FormBuilderCollection
     */
    private $formBuilderCollection;


    /**
     * @var InfrastructureRepositoryFactoryInterface
     */
    private $userRepository;

    /**
     * Issue5UseCases constructor.
     * @param InfrastructureFormBuilderCollectionInterface $formBuilderCollection
     * @param InfrastructureRepositoryFactoryInterface $userRepository
     */

    public const USER_LOGIN_INFORMATIONS_IS_VALID = "userLoginInformationsIsValid";

    public const USER_LOGIN_INFORMATIONS_ISNT_VALID = "userLoginInformationsIsntValid";

    public function __construct(InfrastructureFormBuilderCollectionInterface $formBuilderCollection, RepositoryAdapterInterface $userRepository )
    {
        $this -> formBuilderCollection = $formBuilderCollection;
        $this -> userRepository = $userRepository;
    }


    /**
     * @return array
     */
    public function process(): array
    {
        $loginForm = $this -> formBuilderCollection -> getForm("LoginType");

        if( $loginForm -> isSubmitted() ) {

            if( $loginForm -> isValid() ) {

                return $this -> userIdentification( $loginForm );

            }


        }

        return [ "form" => $loginForm -> getView() ];
    }


    /**
     * @param InfrastructureFormBuilderInterface $loginForm
     *
     * @return array
     */
    private function userIdentification( InfrastructureFormBuilderInterface $loginForm ): array {

        $dataForm = $loginForm -> getData();

        $user = $this -> userRepository -> findOneBy(
            array("email" => $dataForm["email"] )
        );

        if( EncryptionServicesGeneric::verifyPassword( $user -> getPassword(), $dataForm["password"]) ) {

            $blogUser = MappingUserToBlogUser::mapping($user);

            return [
                "msg" => self::USER_LOGIN_INFORMATIONS_IS_VALID,
                "blogUser" => $blogUser
            ];

        } else {
            return [ "form" => $loginForm -> getView(),"msg" => self::USER_LOGIN_INFORMATIONS_ISNT_VALID];
        }
    }




}