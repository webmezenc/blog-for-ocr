<?php

namespace App\Controller;

use App\Domain\UseCases\Issue3UseCases;
use App\Domain\UseCases\Issue4UseCases;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Infrastructure\Mailer\MailerFactory;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Request\RequestFactory;
use App\Utils\Generic\ParametersBag;
use App\Utils\Generic\ParametersBagInterface;
use App\Utils\Services\Post\PostServices;
use App\Utils\Services\User\UserServices;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegisterUserController extends AppController
{
    /**
     * @Route("/register", name="register_user")
     */
    public function index( Request $request, ContainerInterface $container )
    {


        try {

            $formBuilderFactory = new FormBuilderFactory( $container, $request );
            $repositoryFactory = new RepositoryFactory( $container );
            $userRepository = $repositoryFactory -> create("User");

            $RegisterUserForm = $formBuilderFactory -> create("RegisterUserType");

            $formBuilderCollection = new FormBuilderCollection();
            $formBuilderCollection -> addForm( $RegisterUserForm );

            $UserServices = new UserServices( $userRepository );

            $MailerFactory = new MailerFactory($container);

            $issue4UseCases = new Issue4UseCases( $formBuilderCollection,$UserServices,$userRepository,$MailerFactory -> create() );

            return $this->render('page/register.html.twig', $issue4UseCases -> process() );

        } catch( \Exception $e ) {
            return $this -> getResponseWithViewError( $e -> getMessage() );
        }


    }


}
