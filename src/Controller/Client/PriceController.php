<?php

namespace App\Controller\Client;

use App\Entity\Client\Price;
use App\Form\Client\PriceType;
use App\Service\Client\PriceService;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PriceController extends AbstractController
{
    private $priceService;

    public function __construct(PriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    /**
     * @Route("/price", name="price_render")
     */
    public function priceRender()
    {
        $form = $this->createForm(PriceType::class);

        return $this->render('client/price_load.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/price/load", name="price_load")
     */
    public function priceLoad(Request $request, FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();

        $price = new Price();
        $form = $this->createForm(PriceType::class, $price);
        $form->handleRequest($request);

        $this->priceService->redirectToAPI();

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $price->getPrice();

            foreach ($files as $file) {
                $fileName =  $this->getParameter('prices_directory').'/'.$fileUploader->upload($file);
                $price->setPrice($fileName);
                $price->setIdCompany(1);
                $em->persist($price);
            }

            $em->flush();

            return $this->redirect($this->generateUrl('price_render'));
        }

        return $this->render('client/price_load.html.twig');
    }
}