<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
<<<<<<< HEAD
     * @Route("/", name="homepage")
=======
     * @Route("/", name="home_index")
>>>>>>> Initial commit
     */
    public function index()
    {
        return $this->render('base.html.twig');
    }


}