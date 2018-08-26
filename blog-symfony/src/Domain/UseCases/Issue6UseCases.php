<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 17:13
 */

namespace App\Domain\UseCases;

use App\Entity\DTO\AddCommentDTO;
use App\Entity\Mapping\MappingUserToBlogUser;
use App\Entity\Post;
use App\Entity\User;
use App\Exception\EntityAlreadyExistException;
use App\Exception\EntityNotValidException;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\GatewayAuthenticateUser;
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
     * @var AddCommentDTO
     */
    private $addCommentDTO;

    /**
     * Issue6UseCases constructor.
     * @param AddCommentDTO $addCommentDTO
     */
    public function __construct( AddCommentDTO $addCommentDTO )
    {
        $this -> addCommentDTO = $addCommentDTO;
    }

    /**
     * @return array
     */
    public function process(): array
    {
        $addTypeForm = $this -> addCommentDTO -> formbuildercollection -> getForm("AddCommentType");

        if( $addTypeForm -> isSubmitted() ) {

            return $this->actionWhenFormIsSubmitted($addTypeForm);

        }

        return [ "form" => $addTypeForm -> getView() ];
    }

    /**
     * @param InfrastructureFormBuilderInterface $addTypeForm
     * @return array
     */
    private function actionWhenFormIsSubmitted(InfrastructureFormBuilderInterface $addTypeForm): array
    {
        if (!$addTypeForm->isValid()) {
            return ["form" => $addTypeForm->getView(), "constraintErrors" => $addTypeForm->getErrors()->__toString()];
        } else {
            //Add comment in database
            return [];
        }
    }

    /**
     *
     */
    private function addComment()  {

        if( $this -> addCommentDTO -> gatewayAuthenticateUser -> getUser() instanceof User ) {

            $Post = $this -> addCommentDTO -> postRepository -> findOneBy( [
                "slug" => $this -> addCommentDTO -> slugPost
            ]);

            if( $Post instanceof Post ) {

            }
        }
    }


    private function hydrateCommentAndPersistThem() {

    }

}