<?php

namespace App\Controller\Tyres;

use App\Entity\Client\Company;
use App\Entity\Tyres\Tyre;
use App\Form\Tyres\TyreType;
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
     * @Route("/new", name="tyre_new", methods="GET|POST")
     */
    public function new(Request $request)
    {
        $tyre = new Tyre();
//        $tyre->setUser($this->getUser());

        $form = $this->createForm(TyreType::class, $tyre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }

        return $this->render('tyre/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}