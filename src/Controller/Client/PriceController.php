<?php

namespace App\Controller\Client;

use App\Entity\Client\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client/price")
 */
class PriceController extends AbstractController
{
    /**
     * @Route("/{id}", name="client_price_index", methods="GET|POST")
     */
    public function index(Company $company)
    {
        return $this->render('client/price/index.html.twig', [
            'company' => $company
        ]);
    }
}