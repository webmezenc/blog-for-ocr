<?php

namespace App\Controller;

use App\Domain\UseCases\Issue8UseCases;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Infrastructure\Mailer\MailerFactory;
use App\Infrastructure\Render\RenderFactory;
use App\Utils\Generic\ParametersBag;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactAdministratorController extends AppController
{

    /**
     * @var Request
     */
    private $request;

    /**
     * @Route("/contact", name="contact_administrator")
     */
    public function index(  Request $request )
    {
        $this -> request = $request;

        return $this -> processController( array($this,'contactAdministrator'), array(0,10) );

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAdministrator() {

        return $this->render('page/contact-administrator.html.twig',
            $this -> getArrayUseCase()
        );

    }


    private function getArrayUseCase():array {

        $mailerFactory = new MailerFactory($this -> container);
        $mailer = $mailerFactory -> create();

        $renderFactory = new RenderFactory($this -> container);
        $render = $renderFactory -> create();

        $parameterBag = new ParametersBag();
        $parameterBag -> add( ["email_administrator" => $this -> getParameter("email")["administrator"]] );


        $issue8UseCases = new Issue8UseCases($this -> getFormBuilderCollection(), $parameterBag,$mailer,$render);
       return $issue8UseCases -> process();

    }

    /**
     * @return FormBuilderCollection
     *
     * @throws \App\Exception\FormBuilderIsAlreadyInCollectionException
     * @throws \App\Exception\FormNotFoundException
     */
    private function getFormBuilderCollection(): FormBuilderCollection {

        $formBuilderFactory = new FormBuilderFactory($this -> container, $this -> request);

        $contactAdministratorForm = $formBuilderFactory -> create("ContactAdministratorType");

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $contactAdministratorForm );

        return $formBuilderCollection;
    }
}
