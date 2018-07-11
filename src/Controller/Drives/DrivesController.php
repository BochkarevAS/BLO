<?php

namespace App\Controller\Drives;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DrivesController extends AbstractController
{
    /**
     * @Route("/drives", name="drives_render")
     */
    public function renderDrives()
    {



        return $this->render('drives/drives_render.html.twig', [

        ]);
    }

}