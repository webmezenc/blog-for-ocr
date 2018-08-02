<?php

namespace App\Controller;

use App\Entity\Post;
use App\Utils\Services\Post\PostServices;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostListController extends AppController
{
    /**
     * @Route("/post/list", name="post_list")
     */
    public function index()
    {
       return $this -> createPagePostList(0,10);
    }


    /**
     * @Route("/post/list/{pageNumber}", name="post_list_page")
     */
    public function pageList( int $pageNumber )
    {
        $start = $pageNumber * 10;

        return $this -> createPagePostList( $start,10, $pageNumber );
    }


    /**
     * @param int $start
     * @param int $numberPost
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function createPagePostList( int $start, int $numberPost, int $actualPage = 0 ): Response
    {

        $PostRepository = $this -> getDoctrine() -> getRepository(Post::class);
        $PostServices = new PostServices( $PostRepository );

        try {

            $postList = $PostServices -> getListPost($start,$numberPost );

            return $this->render('page/post-list.html.twig', [
                'postList' => $postList,
                'postNumber' => $PostRepository -> getNumberOfValidPost(),
                'actualPage' => $actualPage
            ]);

        } catch( \Exception $e ) {
            return $this -> getResponseWithViewError( $e -> getMessage() );
        }

    }


}
