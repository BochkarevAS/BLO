<?php

namespace App\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client/cabinet")
 */
class CabinetController extends AbstractController
{
    /**
     * @Route("/", name="client_cabinet_index", methods="GET")
     */
    public function index()
    {
        return $this->render('client/cabinet/index.html.twig');
    }
}