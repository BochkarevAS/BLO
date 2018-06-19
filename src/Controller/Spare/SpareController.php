<?php

namespace App\Controller\Spare;

use App\Entity\Spare\Engine;
use App\Entity\Spare\Model;
use App\Form\Spare\SpareType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SpareController extends AbstractController
{
    /**
     * @Route("/spare", name="spare_render")
     */
    public function renderSpare(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(SpareType::class);
        $query = $em->getRepository(Model::class)->spareAll();
//        $query = $em->getRepository(Engine::class)->findAll();

//        echo count($query);
//        die;

        if (!$query) {
            throw $this->createNotFoundException();
        }

        $spares = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('spare/render.html.twig', [
            'spares' => $spares,
            'form'   => $form->createView()
        ]);
    }
}