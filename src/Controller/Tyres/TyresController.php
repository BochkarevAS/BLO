<?php

namespace App\Controller\Tyres;

use App\Entity\Tyres\Tyre;
use App\Service\Tyres\TyresService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TyresController extends AbstractController
{
    /**
     * @Route("/tyres", name="tyres_render")
     */
    public function renderTyres(Request $request, PaginatorInterface $paginator)
    {
        $query = $this->getDoctrine()->getRepository(Tyre::class)->renderTyre();

        $tyres = $paginator->paginate($query, $request->query->getInt('page', 1), 20);


        return $this->render('tyres/tyres_render.html.twig', [
            'tyres' => $tyres,
        ]);
    }

    /**
     * @Route("/tyres/parse", name="tyres_parse")
     */
    public function parseTyre(TyresService $tyresService)
    {
        $tyresService->parse();

        return $this->render('tyres/tyres_render.html.twig', [

        ]);
    }
}