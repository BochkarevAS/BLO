<?php

namespace App\Controller\Tyres;

use App\Entity\Tyres\Tyre;
use App\Form\Tyres\TyreType;
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
        $tyre = new Tyre();
        $form = $this->createForm(TyreType::class, $tyre, ['method' => 'GET']);
        $form->handleRequest($request);
        $pictures = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();
            $query = $this->getDoctrine()->getRepository(Tyre::class)->renderTyres($entity);

            if ($query) {
                $pictures = $paginator->paginate($query, $request->query->getInt('page', 1), 20);
            }
        }

        return $this->render('tyres/tyres_render.html.twig', [
            'pictures' => $pictures,
            'form'     => $form->createView()
        ]);
    }

    /**
     * @Route("/tyres/parse", name="tyres_parse")
     */
    public function parseTyre(TyresService $tyresService)
    {
        $tyresService->parse();

        return $this->redirectToRoute('tyres_render');
    }
}