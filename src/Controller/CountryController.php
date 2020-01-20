<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Country;
use App\Form\CountryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{
    /**
     * @Route("country/index", name="country_index",  methods="GET|POST")
     */
    public function index()
    {
        $countrys = $this->getDoctrine()->getRepository(Country::class)->findAll();

        return $this->render('country/countrys.html.twig', [
            'countrys' => $countrys
        ]);
    }

    /**
     * @Route("country/create", name="country_create",  methods="GET|POST")
     */
    public function create(Request $request)
    {
        $data = new Country();
        $form = $this->createForm(CountryType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash("success", "Ваше объявление создано");

            return $this->redirectToRoute('country_create', [
                'id' => $data->getId()
            ]);
        }

        return $this->render('country/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("country/{id}/edit", name="country_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Country $data)
    {
        $form = $this->createForm(CountryType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash("success", "Ваше объявление обновлено");

            return $this->redirectToRoute('country_edit', [
                'id' => $data->getId()
            ]);
        }

        return $this->render('country/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}