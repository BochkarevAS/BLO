<?php

namespace App\Controller\Client;

use App\Entity\Client\Company;
use App\Entity\Client\Price;
use App\Form\Client\PriceType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client/price")
 */
class PriceController extends AbstractController
{
    /**
     * @Route("/{id}", name="client_price_index")
     */
    public function index(Request $request, Company $company, FileUploader $fileUploader): Response
    {
        $price = new Price();
        $form = $this->createForm(PriceType::class, $price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $files = $price->getFile();
            $paths = [];

            foreach ($files as $file) {
                $targetDirectory = $this->getParameter('prices_directory');
                $fileName = $targetDirectory.'/'.$fileUploader->upload($file, $targetDirectory);
                $price->setFile($fileName);
                $price->setCompany($company);
                $paths[] = $fileName;

                $em->persist($price);
            }

            $em->flush();

            return $this->redirectToRoute('client_price_index', ['id' => $company->getId()]);
        }

        return $this->render('client/price/index.html.twig', [
            'company' => $company,
            'form'    => $form->createView()
        ]);
    }
}