<?php

namespace App\Controller\Client;

use App\Entity\Client\Company;
use App\Form\Client\CompanyType;
use App\Repository\Client\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client/company")
 */
class CompanyController extends Controller
{
    /**
     * @Route("/", name="client_company_index", methods="GET")
     */
    public function index(CompanyRepository $companyRepository): Response
    {
        $user = $this->getUser();

        return $this->render('client/company/index.html.twig', [
            'companys' => $companyRepository->getCompanyByUserId($user),
            'user'     => $user
        ]);
    }

    /**
     * @Route("/show/all", name="client_company_show_all", methods={"GET"})
     */
    public function showAll(CompanyRepository $repository)
    {
        return $this->render('client/company/show_all.html.twig', [
            'companys' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="client_company_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $company = new Company();
        $company->setUser($this->getUser());

        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            return $this->redirectToRoute('client_company_index');
        }

        return $this->render('client/company/new.html.twig', [
            'company' => $company,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="client_company_show", methods="GET")
     */
    public function show(Company $company): Response
    {
        return $this->render('client/company/show.html.twig', [
            'company' => $company
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_company_edit", methods="GET|POST")
     */
    public function edit(Request $request, Company $company): Response
    {
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_company_edit', [
                'id' => $company->getId()
            ]);
        }

        return $this->render('client/company/edit.html.twig', [
            'company' => $company,
            'form'    => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="client_company_delete", methods="DELETE")
     */
    public function delete(Request $request, Company $company): Response
    {
        if ($this->isCsrfTokenValid('delete'.$company->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($company);
            $em->flush();
        }

        return $this->redirectToRoute('client_company_index');
    }
}