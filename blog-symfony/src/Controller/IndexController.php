<?php

namespace App\Controller;

use App\Domain\UseCases\Issue10UseCases;
use App\Entity\Post;
use App\Utils\Services\Post\PostServices;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends AppController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this -> processController( array($this,'indexBlog'), [] );
    }

    public function indexBlog() {
        return $this->render('page/index.html.twig', $this -> getDataInUseCase() );
    }


    private function getDataInUseCase(): array {
        $postRepository = $this -> getDoctrine() -> getRepository(Post::class );
        $postServices = new PostServices( $postRepository );

        $issue10UseCases = new Issue10UseCases( $postServices );

        return $issue10UseCases -> process();
    }
}
