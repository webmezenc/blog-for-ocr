<?php

namespace App\Controller;

use App\Domain\UseCases\Issue3UseCases;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Request\RequestFactory;
use App\Utils\Generic\ParametersBag;
use App\Utils\Generic\ParametersBagInterface;
use App\Utils\Services\Post\PostServices;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegisterUserController extends AppController
{
    /**
     * @Route("/register", name="view_post")
     */
    public function index( Request $request, ContainerInterface $container )
    {


        try {

            $parameterBag = new ParametersBag();

            $arrUseCase = $this -> getArrayDataOfUseCase( $container,$parameterBag );

            return $this->render('register'  );

        } catch( \Exception $e ) {
            return $this -> getResponseWithViewError( $e -> getMessage() );
        }


    }


}
