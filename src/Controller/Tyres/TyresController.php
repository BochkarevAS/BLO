<?php

namespace App\Controller\Tyres;

use App\Service\Tyres\TyresService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TyresController extends AbstractController
{
    /**
     * @Route("/tyres", name="tyres_render")
     */
    public function parseTyre(TyresService $tyresService)
    {
        $tyresService->parse();

        return $this->render('tyres/tyres_render.html.twig', [

        ]);
    }
}