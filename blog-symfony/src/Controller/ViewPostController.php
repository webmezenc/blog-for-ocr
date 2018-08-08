<?php

namespace App\Controller;

use App\Domain\UseCases\Issue3UseCases;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Request\RequestFactory;
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

            $arrUseCase = $this -> getArrayOfUseCase( $container );

            return $this->render('view_post/index.html.twig', [
                'controller_name' => 'ViewPostController',
            ]);
        } catch( \Exception $e ) {
            return $this -> getResponseWithViewError( $e -> getMessage() );
        }


    }


    /**
     * @param ContainerInterface $container
     *
     * @return array
     *
     * @throws \App\Exception\InfrastructureAdapterException
     * @throws \App\Exception\NotFoundException
     * @throws \App\Exception\UnhautorizedException
     */
    private function getArrayOfUseCase( ContainerInterface $container ): array {

        $RepositoryFactory = new RepositoryFactory( $container );
        $postRepository = $RepositoryFactory -> create("Post");

        $Request = RequestFactory::create();

        $postServices = new PostServices( $postRepository );
        $issue3UseCase = new Issue3UseCases( $postServices,$Request );

        return $issue3UseCase -> process();
    }
}
