<?php

namespace App\Controller\Client;

use App\Form\Client\CompanyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * @Route("/create/company", name="create_company")
     */
    public function createCompany(Request $request)
    {
        $form = $this->createForm(CompanyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }

        return $this->render('client/company_add_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

}