<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewPostController extends AppController
{
    /**
     * @Route("/view/{slug}", name="view_post")
     */
    public function index( string $slug )
    {

        //TODO - récupérer l'article

        //TODO - récupérer les commentaires

        return $this->render('view_post/index.html.twig', [
            'controller_name' => 'ViewPostController',
        ]);
    }
}
