<?php

namespace App\Controller\Spare;

use App\Entity\Spare\Model;
use App\Form\Spare\SpareType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SpareController extends AbstractController
{
    /**
     * @Route("/spare", name="spare_render")
     */
    public function renderSpare()
    {
        $form = $this->createForm(SpareType::class);

        return $this->render('spare/render.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/spare/search", name="spare_search")
     */
    public function searchSpare(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(SpareType::class);
        $form->handleRequest($request);

        $spare = $em->getRepository(Model::class)->searchSpareByMarkModel();


//        return $this->render('spare/render.html.twig', [
//            'form' => $form->createView()
//        ]);

        var_dump($spare);
//        return new Response('<html><body>1</body></html>');
        die;
    }
}