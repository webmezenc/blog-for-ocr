<?php

namespace App\Controller;

use App\Domain\Command\Post\DeletePostWithActualUser;
use App\Domain\UseCases\Issue36UseCases;
use App\Infrastructure\Gateway\AuthenticateUser\AuthenticateUserFactory;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AdminDeletePostController extends AppController
{

    /**
     * @var string
     */
    private $slug;

    /**
     * @var Security
     */
    private $security;


    /**
     * @Route("/admin/post/delete/{slug}", name="admin_delete_post")
     */
    public function index($slug, Security $security)
    {
        $this -> slug = $slug;
        $this -> security = $security;

        return $this -> processController( array($this,'deletePost'), [] );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \App\Exception\EntityNotFoundException
     * @throws \App\Exception\InfrastructureAdapterException
     * @throws \App\Exception\ParameterIsNotFoundException
     */
    public function deletePost() {

        $issue36UseCase = $this -> getInstanceOfUseCase();

        $issue36UseCase -> setSlug($this -> slug);

        return $this -> render("admin/delete-post.html.twig", $issue36UseCase -> process());

    }

    /**
     * @return Issue36UseCases
     *
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getInstanceOfUseCase() {

        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("Post");

        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create();

        $authenticateUserFactory = new AuthenticateUserFactory($this -> container);
        $gatewayAuthenticateUser = $authenticateUserFactory -> create();

        return new Issue36UseCases($postRepository,new DeletePostWithActualUser($gatewayAuthenticateUser,$validator,$postRepository));

    }


}
