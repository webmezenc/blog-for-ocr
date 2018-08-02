<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\ValueObject\OrderLimit;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DebugController extends Controller
{
    /**
     * @Route("/debug", name="debug")
     */
    public function index()
    {
        $orderLimit = new OrderLimit();

        $postList = $this -> getDoctrine() -> getRepository(Post::class ) -> getNumberOfValidPost();

        var_dump( $postList );

    }

}
