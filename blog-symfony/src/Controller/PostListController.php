<?php

namespace App\Controller;

use App\Entity\Post;
use App\Utils\Services\Post\PostServices;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostListController extends AppController
{
    /**
     * @Route("/post/list", name="post_list")
     */
    public function index()
    {

        $PostRepository = $this -> getDoctrine() -> getRepository(Post::class);
        $PostServices = new PostServices( $PostRepository );

        try {

            $postList = $PostServices -> getListPost(0,10 );

            return $this->render('page/post-list.html.twig', [
                'postList' => $postList,
            ]);

        } catch( \Exception $e ) {
            return $this -> getResponseWithViewError( $e -> getMessage() );
        }

    }
}
