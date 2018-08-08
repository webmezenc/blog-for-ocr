<?php

namespace App\Controller;

use App\Domain\UseCases\Issue3UseCases;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Request\RequestFactory;
use App\Utils\Generic\ParametersBag;
use App\Utils\Generic\ParametersBagInterface;
use App\Utils\Services\Post\PostServices;
use Psr\Container\ContainerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewPostController extends AppController
{
    /**
     * @Route("/view/{slug}", name="view_post")
     */
    public function index( string $slug, ContainerInterface $container )
    {


        try {

            $parameterBag = new ParametersBag( array("slug" => $slug ) );

            $arrUseCase = $this -> getArrayDataOfUseCase( $container,$parameterBag );

            return $this->render('page/post-view.html.twig', $arrUseCase );

        } catch( \Exception $e ) {
            return $this -> getResponseWithViewError( $e -> getMessage() );
        }


    }


    /**
     * @param ContainerInterface $container
     * @param ParametersBagInterface $parameterBag
     *
     * @return array
     *
     * @throws \App\Exception\InfrastructureAdapterException
     * @throws \App\Exception\NotFoundException
     * @throws \App\Exception\UnhautorizedException
     */
    private function getArrayDataOfUseCase( ContainerInterface $container, ParametersBagInterface $parameterBag ): array {

        $RepositoryFactory = new RepositoryFactory( $container );
        $postRepository = $RepositoryFactory -> create("Post");

        $Request = RequestFactory::create();

        $postServices = new PostServices( $postRepository );
        $issue3UseCase = new Issue3UseCases( $postServices,$Request,$parameterBag );

        return $issue3UseCase -> process();
    }
}
