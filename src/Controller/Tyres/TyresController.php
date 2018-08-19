<?php

namespace App\Controller\Tyres;

<<<<<<<<< Temporary merge branch 1
=========
use App\Entity\Client\Company;
>>>>>>>>> Temporary merge branch 2
use App\Entity\Tyres\Tyre;
use App\Form\Tyres\TyreType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
<<<<<<<<< Temporary merge branch 1
=========
use Symfony\Component\HttpFoundation\Response;
>>>>>>>>> Temporary merge branch 2
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
<<<<<<<<< Temporary merge branch 1
=========

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
>>>>>>>>> Temporary merge branch 2
}