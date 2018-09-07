<?php

namespace App\Controller;

use App\Domain\Command\Post\EditPostWithActualUser;
use App\Domain\UseCases\Issue35UseCases;
use App\Entity\Post;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\Form\FormBuilderFactory;
use App\Infrastructure\Gateway\AuthenticateUser\AuthenticateUserFactory;
use App\Infrastructure\Validator\ValidatorFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminEditPostController extends PostAdminController
{

    /**
     * @var string
     */
    private $slug;

    /**
     * @var Request
     */
    private $request;

    /**
     * @Route("/admin/post/edit/{slug}", name="admin_edit_post")
     */
    public function index($slug, Request $request)
    {
        $this -> slug = $slug;
        $this -> request = $request;

        return $this -> processController( array($this,'getEditPost'), [] );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \App\Exception\EntityParametersErrorException
     * @throws \App\Exception\FormInstanceNotFoundException
     * @throws \App\Exception\InfrastructureAdapterException
     * @throws \App\Exception\UnhautorizedException
     */
    public function getEditPost() {
        $this -> getRepositories();

        $issue35UseCase = new Issue35UseCases($this -> getFormBuilderCollection(),$this -> getInstanceOfEditPostWithActualUser());

        return $this->render('admin/edit-post.html.twig', $issue35UseCase -> process());
    }

    /**
     * @return EditPostWithActualUser
     *
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getInstanceOfEditPostWithActualUser(): EditPostWithActualUser {
        $validatorFactory = new ValidatorFactory();
        $validator = $validatorFactory -> create();

        $authenticateUserFactory = new AuthenticateUserFactory($this -> container);
        $authenticateUser = $authenticateUserFactory -> create();

        return new EditPostWithActualUser($validator,$authenticateUser,$this -> repositories["Post"]);
    }

    /**
     * @return FormBuilderCollection
     *
     * @throws \App\Exception\FormBuilderIsAlreadyInCollectionException
     * @throws \App\Exception\FormNotFoundException
     * @throws \App\Exception\InfrastructureAdapterException
     * @throws \App\Exception\TypeErrorException
     */
    private function getFormBuilderCollection(): FormBuilderCollection {

        $formBuilderFactory = new FormBuilderFactory($this -> container,$this -> request);
        $formBuilderFactory -> setEntityToFill($this -> getPostWithSlug());
        $addOrEditPostType = $formBuilderFactory -> create("AddOrEditPostType", FormBuilderFactory::DEFAULT_BUILDER,[
            "postcategory" => $this -> repositories["PostCategory"] -> findAll()
        ]);

        $formBuilderCollection = new FormBuilderCollection();
        $formBuilderCollection -> addForm($addOrEditPostType);

        return $formBuilderCollection;

    }

    /**
     * @return Post
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getPostWithSlug(): Post {
        return $this -> repositories["Post"] -> findOneBy(["slug" => $this -> slug ]);
    }

}
