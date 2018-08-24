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

class Issue6UseCases implements UseCasesLogicInterface
{
    /**
     * @var FormBuilderCollection
     */
    private $formbuildercollection;

    public function __construct( InfrastructureFormBuilderCollectionInterface $formBuilderCollection )
    {
        $this -> formbuildercollection = $formBuilderCollection;
    }

    /**
     * @return array
     */
    public function process(): array
    {
        $addTypeForm = $this -> formbuildercollection -> getForm("AddCommentType");

        return [ "form" => $addTypeForm -> getView() ];
    }


}