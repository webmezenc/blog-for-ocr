<?php

namespace App\Controller;

use App\Domain\UseCases\Issue5UseCases;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Infrastructure\InfrastructureFormBuilderCollectionInterface;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Security\User\BlogUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginController extends AppController
{
    /**
     * @Route("/login", name="login")
     */
    public function index( Request $request, Security $security, AuthenticationUtils $authenticationUtils )
    {
        $params = [
            "last_username" => $authenticationUtils -> getLastUsername(),
            "error" => $authenticationUtils -> getLastAuthenticationError()
        ];

        if( !is_null($security -> getUser()) ) {
            $params["alreadyConnected"] = true;
        }

        return $this->render('page/login.html.twig',$params );
    }


    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \App\Exception\FormBuilderIsAlreadyInCollectionException
     * @throws \App\Exception\FormNotFoundException
     */
    /*
    public function loginProcess( request $request ) {

        $formBuilderCollection = $this -> getFormBuilderCollection( $request );

        $issue5UseCases = new Issue5UseCases($formBuilderCollection,$this -> getUserRepository() );
        $arrParams = $issue5UseCases -> process();

        if( key_exists("blogUser",$arrParams) ) {
            $this -> authentificateUser( $arrParams["blogUser"], $request );
            unset( $arrParams["blogUser"] );
        }

        return $this->render('page/login.html.twig', $arrParams);
    }


    private function getUserRepository() {
        $repositoryFactory = new RepositoryFactory( $this -> container );
        return $repositoryFactory -> create("User");
    }
    */
    /**
     * @param Request $request
     *
     * @return InfrastructureFormBuilderCollectionInterface
     *
     * @throws \App\Exception\FormBuilderIsAlreadyInCollectionException
     * @throws \App\Exception\FormNotFoundException
     */
    /*
    private function getFormBuilderCollection( Request $request ): InfrastructureFormBuilderCollectionInterface {
        $formBuilderFactory = new FormBuilderFactory( $this -> container, $request );
        $LoginForm = $formBuilderFactory -> create("LoginType");

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $LoginForm );

        return $formBuilderCollection;
    }
    */
    /**
     * @param BlogUser $blogUser
     * @param Request $request
     */
    /*
    private function authentificateUser( BlogUser $blogUser, Request $request ) {

        $token = new UsernamePasswordToken($blogUser, null, 'bloguser', $blogUser->getRoles());
        $this->get('security.token_storage')->setToken($token);

        $this->get('session')->set('_security_main', serialize($token));

    }
    */
}
