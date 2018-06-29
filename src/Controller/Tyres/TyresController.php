<?php

namespace App\Controller\Tyres;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TyresController extends AbstractController
{
    /**
     * @Route("/tyres", name="tyres_render")
     */
    public function renderTyre()
    {


        return $this->render('tyres/tyres_render.html.twig', [

        ]);
    }
}