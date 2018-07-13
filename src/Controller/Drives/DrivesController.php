<?php

namespace App\Controller\Drives;

use App\Entity\Drives\Drive;
use App\Form\Drives\DriveType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DrivesController extends AbstractController
{
    /**
     * @Route("/drives", name="drives_render")
     */
    public function renderDrives(Request $request)
    {
        $drive = new Drive();
        $form = $this->createForm(DriveType::class, $drive, ['method' => 'GET']);
        $form->handleRequest($request);



        return $this->render('drives/drives_render.html.twig', [
            'form' => $form->createView()
        ]);
    }

}