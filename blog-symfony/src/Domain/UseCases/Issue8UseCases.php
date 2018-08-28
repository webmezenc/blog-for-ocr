<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 28/08/2018
 * Time: 11:48
 */

namespace App\Domain\UseCases;


use App\Entity\ValueObject\ContactAdministratorForm;
use App\Exception\ParameterIsNotFoundException;
use App\Infrastructure\InfrastructureFormBuilderCollectionInterface;
use App\Infrastructure\InfrastructureFormBuilderInterface;
use App\Infrastructure\InfrastructureMailerInterface;
use App\Infrastructure\InfrastructureRenderInterface;
use App\Infrastructure\Mailer\Mailer;
use App\Utils\Generic\ParametersBagInterface;

class Issue8UseCases implements UseCasesLogicInterface
{

    const SUBJECT_EMAIL_ADMINISTRATOR = "Nouvelle prise de contact sur le blog";

    /**
     * @var InfrastructureFormBuilderCollectionInterface
     */
    private $formBuilderCollection;

    /**
     * @var ParametersBagInterface
     */
    private $parametersBag;

    /**
     * @var InfrastructureMailerInterface
     */
    private $mailer;

    /**
     * @var InfrastructureRenderInterface
     */
    private $render;

    public function __construct(
        InfrastructureFormBuilderCollectionInterface $formBuilderCollection,
        ParametersBagInterface $parametersBag,
        InfrastructureMailerInterface $mailer,
        InfrastructureRenderInterface $render
    )
    {
        $this -> parametersBag = $parametersBag;
        $this -> mailer = $mailer;
        $this -> formBuilderCollection = $formBuilderCollection;
        $this -> render = $render;
    }

    public function process(): array
    {
        $contactAdministratorType = $this -> formBuilderCollection -> getForm("ContactAdministratorType");

        if( $contactAdministratorType -> isSubmitted() ) {

            return $this -> actionWithStateForm( $contactAdministratorType );
        }

        return [
            "form" => $contactAdministratorType -> getView()
        ];
    }

    /**
     * @param InfrastructureFormBuilderInterface $contactAdministratorType
     * @return array
     */
    private function actionWithStateForm( InfrastructureFormBuilderInterface $contactAdministratorType ) {

        if( !$contactAdministratorType -> isValid() ) {
            return [
                "form" => $contactAdministratorType -> getView(),
                "msg" => "formIsInvalid"
            ];
        }
        else {

            $ContactAdministratorForm = $contactAdministratorType -> getData();
            return $this -> sendEmailToAdministrator( $ContactAdministratorForm );

        }

    }


    /**
     * @param ContactAdministratorForm $ContactAdministratorForm
     *
     * @return array
     *
     * @throws ParameterIsNotFoundException
     */
    private function sendEmailToAdministrator( ContactAdministratorForm $ContactAdministratorForm ): array {

        if( !$this -> parametersBag -> has("email_administrator") ) {
            throw new ParameterIsNotFoundException("Required parameter named 'email_administrator' isn't found");
        }

        $this -> mailer -> setSender( Mailer::DEFAULT_SENT_EMAIL );
        $this -> mailer -> setReplyTo( $ContactAdministratorForm -> email );
        $content = $this -> getTemplate( $ContactAdministratorForm );
        $this -> mailer -> setContent($content);
        $this -> mailer -> setSubject( self::SUBJECT_EMAIL_ADMINISTRATOR );

        if( $this -> mailer -> send() ) {
           return ["msg" => "msgSentSuccess"];
        }

    }

    /**
     * @param ContactAdministratorForm $ContactAdministratorForm
     * @return string
     */
    private function getTemplate( ContactAdministratorForm $ContactAdministratorForm  ): string {
        return $this -> render -> renderView("email/contactadministrator.html.twig",
            [
                "subject" => $ContactAdministratorForm -> subject,
                "message" => $ContactAdministratorForm -> message
            ]);
    }
}