<?php

namespace App\Controller\Parts;

use App\Entity\Parts\Oem;
use App\Form\Parts\OemType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PartsController extends AbstractController
{
    /**
     * @Route("/parts", name="parts_render", options={"expose"=true})
     */
    public function renderParts(Request $request, PaginatorInterface $paginator)
    {
        $oem = new Oem();
        $form = $this->createForm(OemType::class, $oem, ['method' => 'GET']);
        $form->handleRequest($request);
        $oems = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();
            $query = $this->getDoctrine()->getRepository(Oem::class)->renderParts($entity);

            if ($query) {
                $oems = $paginator->paginate($query, $request->query->getInt('page', 1), 5);
            }
        }

        return $this->render('parts/parts_render.html.twig', [
            'oems' => $oems,
            'form' => $form->createView()
        ]);
    }
}