<?php

namespace App\Controller;

use App\Domain\Command\Comment\AddCommentWithUserAndPost;
use App\Domain\UseCases\Issue3UseCases;
use App\Domain\UseCases\Issue52UseCases;
use App\Domain\UseCases\Issue6UseCases;
use App\Entity\DTO\AddCommentDTO;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Infrastructure\Gateway\AuthenticateUser\AuthenticateUserFactory;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Request\RequestFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use App\Utils\Generic\ParametersBag;
use App\Utils\Generic\ParametersBagInterface;
use App\Utils\Services\Comment\CommentServices;
use App\Utils\Services\Post\PostServices;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Security;

class ViewPostController extends AppController
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @Route("/view/{slug}", name="view_post")
     */
    public function index( string $slug, ContainerInterface $container, Security $security, Request $request )
    {

        $this -> request = $request;

        try {

            $arrRepository = $this -> getRepository($container);

            $parameterBag = new ParametersBag( array("slug" => $slug ) );

            $arrUseCase = $this -> getArrayDataOfUseCase( $container,$parameterBag,$arrRepository );

            if( !is_null($security -> getUser()) ) {
                $arrUseCaseAddComment = $this -> getArrayUseCaseAddComment( $container,$parameterBag,$arrRepository );
                $arrUseCase = array_merge($arrUseCase,$arrUseCaseAddComment);
            }

            return $this->render('page/post-view.html.twig', $arrUseCase );

        } catch( \Exception $e ) {
            return $this -> getResponseWithViewError( $e -> getMessage() );
        }

    }

    /**
     * @param ContainerInterface $container
     * @param ParametersBagInterface $parameterBag
     * @param array $repository
     *
     * @return array
     */
    private function getArrayUseCaseAddComment( ContainerInterface $container, ParametersBagInterface $parameterBag, array $repository ): array {

        $authenticateUserFactory = new AuthenticateUserFactory($container);
        $authenticateUser = $authenticateUserFactory -> create();

        $formBuilderCollection = $this -> getFormBuilderCollection();

        $addCommentDTO = new AddCommentDTO();
        $addCommentDTO -> slugPost = $parameterBag -> get("slug");
        $addCommentDTO -> postRepository = $repository["post"];
        $addCommentDTO -> formbuildercollection = $formBuilderCollection;
        $addCommentDTO -> gatewayAuthenticateUser = $authenticateUser;

        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create();
        $commentsServices = new CommentServices($validator,$repository["comments"] );

        $addCommentWithUserAndPost = new AddCommentWithUserAndPost($authenticateUser,$repository["post"],$commentsServices);

        $issue6UseCase = new Issue6UseCases($addCommentDTO,$addCommentWithUserAndPost);

        return $issue6UseCase -> process();
    }


    /**
     * @param ContainerInterface $container
     * @param ParametersBagInterface $parameterBag
     * @param array $repository
     *
     * @return array
     *
     * @throws \App\Exception\InfrastructureAdapterException
     * @throws \App\Exception\NotFoundException
     * @throws \App\Exception\UnhautorizedException
     */
    private function getArrayDataOfUseCase( ContainerInterface $container, ParametersBagInterface $parameterBag, array $repository ): array {

        $Request = RequestFactory::create();

        $postServices = new PostServices( $repository["post"] );
        $issue52UseCases = new Issue52UseCases($repository["comments"] );
        $issue3UseCase = new Issue3UseCases( $postServices,$Request,$parameterBag,$issue52UseCases );

        return $issue3UseCase -> process();
    }


    /**
     * @return FormBuilderCollection
     *
     * @throws \App\Exception\FormBuilderIsAlreadyInCollectionException
     * @throws \App\Exception\FormNotFoundException
     */
    private function getFormBuilderCollection() {

        $formBuilderFactory = new FormBuilderFactory( $this -> container, $this -> request );
        $addCommentForm = $formBuilderFactory -> create("AddCommentType");

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $addCommentForm );

        return $formBuilderCollection;
    }


    /**
     * @param $container
     * @return array
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getRepository($container): array {

        $RepositoryFactory = new RepositoryFactory( $container );
        $postRepository = $RepositoryFactory -> create("Post");
        $commentsRepository = $RepositoryFactory -> create("Comments");

        return [
            "post" => $postRepository,
            "comments" => $commentsRepository
        ];
    }
}
