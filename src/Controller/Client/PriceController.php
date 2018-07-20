<?php

namespace App\Controller\Client;

use App\Entity\Client\Company;
use App\Entity\Client\Price;
use App\Form\Client\PriceType;
use App\Service\Client\PriceService;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client/price")
 */
class PriceController extends AbstractController
{
    /**
     * @Route("/{id}", name="client_price_load")
     */
    public function load(Request $request, Company $company, FileUploader $fileUploader, PriceService $priceService)
    {
        $price = new Price();
        $form = $this->createForm(PriceType::class, $price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $files = $price->getPath();

            foreach ($files as $file) {
                $fileName = $this->getParameter('prices_directory').'/'.$fileUploader->upload($file);
                $price->setPath($fileName);
                $price->setCompanyId($company->getId());
                $em->persist($price);
            }

            $em->flush();

            return $this->redirectToRoute('client_price_load', ['id' => $company->getId()]);
        }

        return $this->render('client/price/load.html.twig', [
            'company' => $company,
            'form'    => $form->createView()
        ]);
    }
}