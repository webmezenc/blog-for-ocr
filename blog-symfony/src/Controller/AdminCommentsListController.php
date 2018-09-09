<?php

namespace App\Controller;

use App\Domain\UseCases\Issue42UseCases;
use App\Entity\Comments;
use App\Infrastructure\Repository\RepositoryFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentsListController extends AppController
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @Route("/admin/comments", name="admin_comments_list")
     */
    public function index(Request $request)
    {
        $this -> request = $request;
        return $this -> processController( array($this,'getCommentsList'), [] );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \App\Exception\InfrastructureAdapterException
     * @throws \App\Exception\ParameterInvalidException
     */
    public function getCommentsList() {
        $repositoryFactory = new RepositoryFactory($this -> container);
        $commentsRepository = $repositoryFactory -> create("Comments");

        $issue42UseCases = new Issue42UseCases($commentsRepository);

        if($this->request->query->has("state")) {
            $issue42UseCases->setState($this->request->query->get("state"));
        }

        return $this -> render("admin/list-comments.html.twig",
            array_merge($issue42UseCases -> process(),$this -> getCommentsState())
        );
    }

    /**
     * @return array
     */
    private function getCommentsState(): array {
        return ["commentsState"
            => [
                "Non validé" => Comments::COMMENTS_INVALID,
                "Validé" => Comments::COMMENTS_VALID
            ]
        ];
    }
}
