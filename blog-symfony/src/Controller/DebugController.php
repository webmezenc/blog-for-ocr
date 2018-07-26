<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DebugController extends Controller
{
    /**
     * @Route("/debug", name="debug")
     */
    public function index()
    {
        return $this->render('debug/index.html.twig', [
            'controller_name' => 'DebugController',
        ]);
    }
}
