<?php

namespace App\Controller\Tyres;

use App\Entity\Tyres\Tyre;
use App\Form\Tyres\TyreNewType;
use App\Form\Tyres\TyreType;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tyre")
 */
class TyresController extends AbstractController
{
    /**
     * @Route("/", name="tyre_index", options={"expose"=true})
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $tyre = new Tyre();
        $form = $this->createForm(TyreType::class, $tyre, ['method' => 'GET']);
        $form->handleRequest($request);
        $tyres = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $query  = $this->getDoctrine()->getRepository(Tyre::class)->search($tyre);

            if ($query) {
                $tyres = $paginator->paginate($query, $request->query->getInt('page', 1), 20);
            }
        }

        return $this->render('tyre/index.html.twig', [
            'tyres' => $tyres,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="tyre_show", methods="GET")
     */
    public function show(Tyre $tyre): Response
    {
        return $this->render('tyre/show.html.twig', [
            'tyre' => $tyre
        ]);
    }

    /**
     * @Route("/new", name="tyre_new", options={"expose"=true}, methods="GET|POST")
     */
    public function new(Request $request, FileUploader $fileUploader)
    {
        $tyre = new Tyre();
        $user = $this->getUser();
        $targetDirectory = $this->getParameter('images_directory');

        $form = $this->createForm(TyreNewType::class, $tyre);
        $form->handleRequest($request);

        if (!$request->isXmlHttpRequest() && $form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $files = $fileUploader->uploadMultiple($tyre->getPicture(), $targetDirectory);
            $json = json_encode($files);
            $tyre->setPicture($json);
            $tyre->setUser($user);

            $hash = md5(
                $this->getUser() .
                $tyre->getBrand() .
                $tyre->getModel() .
                $tyre->getCity() .
                $tyre->getWidth() .
                $tyre->getAvailability() .
                $tyre->getCondition() .
                $tyre->getQuantity() .
                $tyre->getDiameter() .
                $tyre->getPicture()
            );

            $tyre->setHash($hash);

            $em->persist($tyre);
            $em->flush();
            $this->addFlash("success", "Ваше объявление добавлено");

            return $this->redirectToRoute('tyre_new');
        }

        return $this->render('tyre/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tyre_edit", methods="GET|POST")
     */
    public function edit(Request $request, Tyre $tyre, FileUploader $fileUploader)
    {
        $targetDirectory = $this->getParameter('images_directory');

        $form = $this->createForm(TyreNewType::class, $tyre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $fileUploader->uploadMultiple($tyre->getPicture(), $targetDirectory);
            $json = json_encode($files);
            $tyre->setPicture($json);

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Ваше объявление обновлено");

            return $this->redirectToRoute('tyre_edit', [
                'id' => $tyre->getId()
            ]);
        }

        return $this->render('tyre/edit.html.twig', [
            '$tyres' => $tyre,
            'form'   => $form->createView()
        ]);
    }
}