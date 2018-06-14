<?php

namespace App\Controller\Spare;

use App\Form\Spare\SpareType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}