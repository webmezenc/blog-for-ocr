<?php

namespace App\Controller;

use App\Domain\UseCases\Issue46UseCases;
use App\Infrastructure\Repository\RepositoryFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminDeleteCommentController extends AppController
{
    /**
     * @var int
     */
    private $id;

    /**
     * @Route("/admin/comments/delete/{id}", name="admin_delete_comment")
     */
    public function index($id)
    {
        $this -> id = $id;
        return $this -> processController( array($this,'deleteComment'), [] );
    }

    /**
     * @return array
     *
     * @throws \App\Exception\InfrastructureAdapterException
     * @throws \App\Exception\ParameterIsNotFoundException
     */
    public function deleteComment() {
        $commentsRepository = $this->getRepository();

        $issue46UseCases = new Issue46UseCases($commentsRepository);
        $issue46UseCases->setIdComment($this -> id);


        return $this -> render("admin/delete-comment.html.twig",$issue46UseCases->process());
    }

    /**
     * @return \App\Infrastructure\Repository\Entity\RepositoryAdapterInterface
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getRepository(): \App\Infrastructure\Repository\Entity\RepositoryAdapterInterface
    {
        $repositoryFactory = new RepositoryFactory($this->container);
        $commentsRepository = $repositoryFactory->create("Comments");
        return $commentsRepository;
    }
}
