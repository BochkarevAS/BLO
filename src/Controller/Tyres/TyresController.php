<?php

namespace App\Controller\Tyres;

<<<<<<< HEAD
=======
use App\Entity\Client\Company;
>>>>>>> d64030f00bcd61c2232c1535f463e9fcecdb7685
use App\Entity\Tyres\Tyre;
use App\Form\Tyres\TyreType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
<<<<<<< HEAD
=======
use Symfony\Component\HttpFoundation\Response;
>>>>>>> d64030f00bcd61c2232c1535f463e9fcecdb7685
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tyres")
 */
class TyresController extends AbstractController
{
    /**
     * @Route("/", name="tyres_index", options={"expose"=true})
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

        return $this->render('tyres/index.html.twig', [
            'tyres' => $tyres,
            'form'  => $form->createView()
        ]);
    }
<<<<<<< HEAD
=======

    /**
     * @Route("/show/{id}", name="tyres_show", methods="GET")
     */
    public function show(Tyre $tyre): Response
    {
        $company = $this->getDoctrine()->getRepository(Company::class)->find($tyre->getCompany());

        return $this->render('tyres/show.html.twig', [
            'company' => $company,
            'tyre'    => $tyre
        ]);
    }
>>>>>>> d64030f00bcd61c2232c1535f463e9fcecdb7685
}