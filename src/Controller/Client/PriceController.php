<?php

namespace App\Controller\Client;

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
    private $priceService;

    public function __construct(PriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    /**
     * @Route("/", name="client_price_index", methods={"GET"})
     */
    public function index()
    {
        $form = $this->createForm(PriceType::class);

        return $this->render('client/price/load.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/load", name="client_price_load")
     */
    public function load(Request $request, FileUploader $fileUploader)
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
                $price->setCompanyId(1);
                $em->persist($price);
            }

            $em->flush();

            return $this->redirectToRoute('client_price_index');
        }

        return $this->render('client/price/load.html.twig', [
            'form' => $form->createView()
        ]);
    }
}