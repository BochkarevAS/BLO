<?php

namespace App\Controller\Client;

use App\Entity\Client\Price;
use App\Form\Client\PriceType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PriceController extends AbstractController
{
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
    public function priceLoad(Request $request/*, FileUploader $fileUploader*/)
    {
        $em = $this->getDoctrine()->getManager();

        $price = new Price();
        $form = $this->createForm(PriceType::class, $price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $price->getPrice()[0];




            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();


//           dump($fileName);
//           return new Response('<html><body>rrr</body></html>');
//           die;

            $file->move(
                $this->getParameter('prices_directory'),
                $fileName
            );

            $price->setPrice($fileName);

            $em->persist($price);
            $em->flush();

            return $this->redirect($this->generateUrl('price_render'));
        }

        return $this->render('client/price_load.html.twig');
    }

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}