<?php

namespace App\Controller\Tyre;

use App\Entity\Tyres\Comment;
use App\Entity\Tyres\Tyre;
use App\Form\Tyre\CommentType;
use App\Form\Tyre\TyreNewType;
use App\Form\Tyre\TyreType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tyre")
 */
class TyreController extends AbstractController
{
    /**
     * @Route("/", name="tyre_index", methods="GET|POST", options={"expose"=true})
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $user = $this->getUser();

        $tyre = new Tyre();
        $form = $this->createForm(TyreType::class, $tyre, ['method' => 'GET']);
        $form->handleRequest($request);
        $tyres = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $tyres = $this->getDoctrine()->getRepository(Tyre::class)->search($tyre, $user);

            if (null !== $tyres) {
                $tyres = $paginator->paginate($tyres, $request->query->getInt('page', 1), 20);
            }
        }

        return $this->render('tyre/index.html.twig', [
            'tyres' => $tyres,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/show", name="tyre_show", methods="GET|POST")
     */
    public function show(Request $request, Tyre $tyre)
    {
        $comment = new Comment();
        $user = $this->getUser();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $comment->setUser($user);
            $comment->setTyre($tyre);
            $comment->setApproved(true);
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('tyre_show', [
                'id' => $tyre->getId()
            ]);
        }

        return $this->render('tyre/show.html.twig', [
            'tyre' => $tyre,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="tyre_new", options={"expose"=true}, methods="GET|POST")
     */
    public function new(Request $request)
    {
        $tyre = new Tyre();
        $user = $this->getUser();
        $form = $this->createForm(TyreNewType::class, $tyre);
        $form->handleRequest($request);

        if (!$request->isXmlHttpRequest() && $form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $tyre->setUser($user);

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
     * @Route("/{id}/edit", name="tyre_edit", options={"expose"=true}, methods="GET|POST")
     */
    public function edit(Request $request, Tyre $tyre)
    {
        $form = $this->createForm(TyreNewType::class, $tyre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Ваше объявление обновлено");

            return $this->redirectToRoute('tyre_edit', [
                'id' => $tyre->getId()
            ]);
        }

        return $this->render('tyre/edit.html.twig', [
            'tyre' => $tyre,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="tyre_delete", methods="DELETE")
     */
    public function delete(Request $request, Tyre $tyre)
    {
        if ($this->isCsrfTokenValid('delete'.$tyre->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tyre);
            $em->flush();
        }

        return $this->redirectToRoute('client_company_index');
    }
}