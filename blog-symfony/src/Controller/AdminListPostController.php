<?php

namespace App\Controller;

use App\Domain\UseCases\Issue34UseCases;
use App\Entity\Post;
use App\Infrastructure\Repository\RepositoryFactory;
use App\Utils\Generic\ParametersBag;
use App\Utils\Generic\ParametersBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminListPostController extends AppController
{

    const LIST_POST_STATE = [
        "Brouillon" => Post::POST_DRAFT,
        "Publié" => Post::POST_PUBLISHED
    ];

    /**
     * @var Request
     */
    private $request;


    /**
     * @Route("/admin/post", name="admin_list_post")
     */
    public function index( Request $request)
    {
        $this -> request = $request;
        return $this -> processController( array($this,'listPost'), [] );
    }

    /**
     * @return ParametersBagInterface
     */
    private function getParameterBag(): ParametersBagInterface {

        if($this -> request -> query -> has("state") && in_array($this -> request -> get("state"),self::LIST_POST_STATE)) {
            return new ParametersBag(["state" => $this -> request -> get("state")]);
        } else {
            return new ParametersBag();
        }
    }

    /**
     * @return Response
     * @throws \App\Exception\InfrastructureAdapterException
     */
    public function listPost(): Response {


        $repositoryFactory = new RepositoryFactory($this -> container);
        $postRepository = $repositoryFactory -> create("Post");

        $issue34UseCases = new Issue34UseCases($postRepository,$this -> getParameterBag());

        return $this -> render("admin/list-post.html.twig",
            [
                "postList" => $issue34UseCases -> process(),
                "postStates" => self::LIST_POST_STATE
            ]
        );
    }
}
