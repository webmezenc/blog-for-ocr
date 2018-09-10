<?php

namespace App\Controller;

use App\Domain\Command\Comment\PublishCommandComment;
use App\Domain\UseCases\Issue45UseCases;
use App\Infrastructure\Repository\RepositoryFactory;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminPublishCommentController extends AppController
{
    /**
     * @var int
     */
    private $id;

    /**
     * @Route("/admin/comments/publish/{id}", name="admin_publish_comment")
     */
    public function index($id)
    {
        $this->id=$id;

        return $this -> processController( array($this,'publishComment'), [] );
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \App\Exception\InfrastructureAdapterException
     */
    public function publishComment() {
        $publishCommandComment = new PublishCommandComment($this->getRepository());
        $issue45UseCase = new Issue45UseCases($publishCommandComment,$this->getRepository());
        $issue45UseCase->setId($this->id);
        return $this -> render("admin/publish-comment.html.twig",$issue45UseCase->process());
    }

    /**
     * @return \App\Infrastructure\Repository\Entity\RepositoryAdapterInterface
     * @throws \App\Exception\InfrastructureAdapterException
     */
    private function getRepository() {
        $repositoryFactory = new RepositoryFactory($this -> container);
        return $repositoryFactory->create("Comments");
    }
}
