<?php

namespace App\Controller;

use App\Domain\UseCases\Issue36UseCases;
use Symfony\Component\Routing\Annotation\Route;

class AdminDeletePostController extends AppController
{
    /**
     * @Route("/admin/post/delete/{slug}, name="admin_delete_post")
     */
    public function index($slug)
    {
        return $this -> processController( array($this,'addPostAdmin'), [$slug] );
    }

    /**
     * @param string $slug
     */
    public function deletePost($slug) {


    }
}
