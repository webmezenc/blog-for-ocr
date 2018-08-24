<?php

namespace App\Controller;

use App\Entity\Post;
use App\Exception\PostServicesException;
use App\Utils\Services\Post\PostServices;
use Doctrine\ORM\EntityNotFoundException;
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
       return $this -> processController( array($this,'createPagePostList'), array(0,10) );
    }


    /**
     * @Route("/post/list/{pageNumber}", name="post_list_page")
     */
    public function pageList( int $pageNumber )
    {
        $start = $pageNumber * 10;

        return $this -> processController( array($this,'createPagePostList'), array($start,10,$pageNumber) );
    }


    /**
     * @param int $start
     * @param int $numberPost
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws PostServicesException
     */
    public function createPagePostList( int $start, int $numberPost, int $actualPage = 0 ): Response
    {

        $PostRepository = $this -> getDoctrine() -> getRepository(Post::class);
        $PostServices = new PostServices( $PostRepository );

        $postList = $PostServices -> getListPost($start,$numberPost );

        return $this->render('page/post-list.html.twig', [
            'postList' => $postList,
            'postNumber' => $PostRepository -> getNumberOfValidPost(),
            'actualPage' => $actualPage
        ]);

    }


}
