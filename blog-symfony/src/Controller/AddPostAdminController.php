<?php

namespace App\Controller;

use App\Domain\Command\Post\AddPostWithActualUser;
use App\Domain\UseCases\Issue14UseCases;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Infrastructure\Gateway\AuthenticateUser\AuthenticateUserFactory;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddPostAdminController extends AppController
{
    /**
     * @var Request
     */
    private $request;


    /**
     * @var array
     */
    private $repositories;


    /**
     * @Route("/admin/post/add", name="add_post_admin")
     */
    public function index(Request $request)
    {
        $this -> request = $request;

        return $this -> processController( array($this,'addPostAdmin'), [] );
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addPostAdmin() {

        $this -> repositories = $this -> getRepositories();
        $dataProcess =  $this -> processData();

        return $this->render('admin/add-post.html.twig',$dataProcess);
    }


    /**
     * @return array
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function processData(): array {

        $issue14UseCase = new Issue14UseCases(
            $this -> getFormBuilderCollection(),
            $this->getAuthenticateUser(),
            $this -> getAddPostCommand()

        );

        return $issue14UseCase -> process();

    }


    /**
     * @return AddPostWithActualUser
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getAddPostCommand(): AddPostWithActualUser {

        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create();

        $addpostWithActualUser = new AddPostWithActualUser($validator,$this->getAuthenticateUser(),$this -> repositories["Post"]);

        return $addpostWithActualUser;
    }


    /**
     * @return FormBuilderCollection
     * @throws \App\Exception\FormBuilderIsAlreadyInCollectionException
     * @throws \App\Exception\FormNotFoundException
     */
    private function getFormBuilderCollection(): FormBuilderCollection {

        $allPostcategory = $this -> repositories["PostCategory"] -> findAll();

        $formBuilderFactory = new FormBuilderFactory($this -> container, $this -> request);
        $addPostForm = $formBuilderFactory -> create("AddPostType", FormBuilderFactory::DEFAULT_BUILDER, array(
          "postcategory" => $allPostcategory
        ));

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm( $addPostForm );

        return $formBuilderCollection;

    }

    /**
     * @return \App\Infrastructure\GatewayAuthenticateUser
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getAuthenticateUser(): \App\Infrastructure\GatewayAuthenticateUser
    {
        $authenticateUserFactory = new AuthenticateUserFactory($this->container);
        $gatewayAuthenticateUser = $authenticateUserFactory->create();
        return $gatewayAuthenticateUser;
    }

    /**
     * @return array
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getRepositories()
    {
        $repositoryFactory = new RepositoryFactory($this->container);
        $postRepository = $repositoryFactory->create("Post");
        $postCategoryRepository = $repositoryFactory->create("PostCategory");

        return [
            "Post" => $postRepository,
            "PostCategory" => $postCategoryRepository
        ];

    }
}
