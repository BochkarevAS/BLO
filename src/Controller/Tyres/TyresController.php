<?php

namespace App\Controller\Tyres;

use App\Entity\Client\Company;
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
            $entity = $form->getData();
            $query  = $this->getDoctrine()->getRepository(Tyre::class)->search($entity);

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
        $company = $this->getDoctrine()->getRepository(Company::class)->find($tyre->getCompany());

        return $this->render('tyre/show.html.twig', [
            'company' => $company,
            'tyre'    => $tyre
        ]);
    }

    /**
     * @Route("/new", name="tyre_new", options={"expose"=true}, methods="GET|POST")
     */
    public function new(Request $request, FileUploader $fileUploader)
    {
        $tyre = new Tyre();
        $targetDirectory = $this->getParameter('images_directory');

        if ($request->isXmlHttpRequest()) {
            $form = $this->createForm(TyreNewType::class, $tyre, ['method' => 'GET']);
            $form->handleRequest($request);

            return $this->render('tyre/new.html.twig', [
                'form' => $form->createView()
            ]);
        }

        $form = $this->createForm(TyreNewType::class, $tyre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $files = $fileUploader->uploadMultiple($tyre->getPicture(), $targetDirectory);
            $json = json_encode($files);
            $tyre->setPicture($json);

            $hash = md5(
                $tyre->getBrand() .
                $tyre->getModel() .
                $tyre->getCity() .
                $tyre->getHash() .
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
}