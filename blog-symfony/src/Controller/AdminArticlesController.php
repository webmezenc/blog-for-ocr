<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminArticlesController extends Controller
{
    /**
     * @Route("/admin/articles", name="admin_articles")
     */
    public function index()
    {
        return $this->render('admin_articles/index.html.twig', [
            'controller_name' => 'AdminArticlesController',
        ]);
    }
}
