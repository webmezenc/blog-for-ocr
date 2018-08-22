<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 17:13
 */

namespace App\Domain\UseCases;

use App\Entity\User;
use App\Entity\ValueObject\Mail;
use App\Exception\EntityAlreadyExistException;
use App\Infrastructure\InfrastructureFormBuilderCollectionInterface;
use App\Infrastructure\InfrastructureFormBuilderInterface;
use App\Infrastructure\InfrastructureMailerInterface;
use App\Infrastructure\Mailer\Mailer;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Utils\Services\User\UserServices;

class Issue4UseCases implements UseCasesLogicInterface
{
    /**
     * @var InfrastructureFormBuilderCollectionInterface
     */
    private $formBuilderCollection;


    /**
     * @var UserServices
     */
    private $userServices;


    /**
     * @var RepositoryAdapterInterface
     */
    private $repository;


    /**
     * @var InfrastructureMailerInterface
     */
    private $mailer;


    public const SUCCESSFULL_REGISTERED = "successfullRegistered";

    public const ALREADY_REGISTRED = "alreadyRegistred";

    public const FORM_IS_INVALID = "formIsInvalid";

    public const TITLE_EMAIL_CONFIRMAION_INSCRIPTION = "Confirmation de l'inscription";



    public function __construct( InfrastructureFormBuilderCollectionInterface $formBuilderCollection,
                                 UserServices $userServices,
                                 RepositoryAdapterInterface $UserRepository,
                                 InfrastructureMailerInterface $mailer )
    {
        $this -> formBuilderCollection = $formBuilderCollection;
        $this -> userServices = $userServices;
        $this -> repository = $UserRepository;
        $this -> mailer = $mailer;
    }


    /**
     * @return array
     */
    public function process(): array
    {
        $RegisterUserForm = $this -> formBuilderCollection -> getForm("RegisterUserType");

        return $this->executeActionwithFormState($RegisterUserForm);
    }

    /**
     * @param $RegisterUserForm
     * @return array
     */
    private function executeActionwithFormState($RegisterUserForm): array
    {

        if ($RegisterUserForm->isSubmitted()) {

            switch( $RegisterUserForm->isValid() ) {
                case true:
                    return $this -> registerUserFormIsValid($RegisterUserForm);
                    break;
                case false:
                    return $this -> registerUserFormIsInvalid( $RegisterUserForm );
                    break;
            }

        }

        return ["view" => $RegisterUserForm->getView()];
    }


    /**
     * @param InfrastructureFormBuilderInterface $RegisterUserForm
     * @return array
     */
    private function registerUserFormIsValid( $RegisterUserForm ) {

        try {

            return $this -> registerUser( $RegisterUserForm );

        } catch( EntityAlreadyExistException $e ) {
            return ["view" => $RegisterUserForm -> getView(), "msgRegisterUser" => self::ALREADY_REGISTRED];
        }

    }


    /**
     * @param InfrastructureFormBuilderInterface $RegisterUserForm
     * @return array
     *
     * @throws EntityAlreadyExistException
     */
    private function registerUser($RegisterUserForm) {

        $User = $RegisterUserForm -> getData();
        $User -> setLevel( User::DEFAULT_LEVEL );
        $User -> setState( User::DEFAULT_STATE );

        $this -> userServices -> register( $User );
        $this -> repository -> flush();

        $this -> sendEmailConfirmationRegister( $User );

        return ["msgRegisterUser" => self::SUCCESSFULL_REGISTERED];
    }


    /**
     * @param User $user
     *
     * @return bool
     */
    private function sendEmailConfirmationRegister( User $user ): bool {

        $this -> mailer -> setSubject(self::TITLE_EMAIL_CONFIRMAION_INSCRIPTION );
        $this -> mailer -> addTo( $user -> getEmail() );
        $this -> mailer -> setSender( Mailer::DEFAULT_SENT_EMAIL, Mailer::DEFAULT_SENT_NAME );
        $this -> mailer -> setReplyTo( Mailer::DEFAULT_REPLYTO_EMAIL );
        $this -> mailer -> setContent( $this->obtainEmailTemplate() );
        return $this -> mailer -> send();

    }


    /**
     * @param $RegisterUserForm
     * @return array
     */
    private function registerUserFormIsInvalid( $RegisterUserForm ) {
        return [
            "view" => $RegisterUserForm->getView(),
            "msgRegisterUser" => self::FORM_IS_INVALID
        ];
    }

    /**
     * @return string
     */
    private function obtainEmailTemplate(): string
    {
        $templateMail = $this->mailer->getEmailTemplate("validationemail.html.twig", $this->mailer->getMailValueObject());
        return $templateMail;
    }


}