<?php

namespace App\Controller\Drive;

use App\Entity\Drives\Comment;
use App\Entity\Drives\Drive;
use App\Form\Drive\CommentType;
use App\Form\Drive\DriveNewType;
use App\Form\Drive\DriveType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/drive")
 */
class DriveController extends AbstractController
{
    /**
     * @Route("/", name="drive_index", methods="GET|POST", options={"expose"=true})
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $user = $this->getUser();

        $drive = new Drive();
        $form = $this->createForm(DriveType::class, $drive, ['method' => 'GET']);
        $form->handleRequest($request);
        $drives = null;

        if (!$request->isXmlHttpRequest() && $form->isSubmitted() && $form->isValid()) {
            $drives = $this->getDoctrine()->getRepository(Drive::class)->search($drive);

            if (null !== $drives) {
                $drives = $paginator->paginate($drives, $request->query->getInt('page', 1), 20);
            }
        }

        return $this->render('drive/index.html.twig', [
            'drives' => $drives,
            'user'   => $user,
            'form'   => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/show", name="drive_show", methods="GET|POST")
     */
    public function show(Request $request, Drive $drive)
    {
        $comment = new Comment();
        $user = $this->getUser();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $comment->setUser($user);
            $comment->setDrive($drive);
            $comment->setApproved(true);
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('drive_show', [
                'id' => $drive->getId()
            ]);
        }

        return $this->render('drive/show.html.twig', [
            'drive' => $drive,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="drive_new", options={"expose"=true}, methods="GET|POST")
     */
    public function new(Request $request)
    {
        $drive = new Drive();
        $user = $this->getUser();
        $form = $this->createForm(DriveNewType::class, $drive);
        $form->handleRequest($request);

        if (!$request->isXmlHttpRequest() && $form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $drive->setUser($user);

            $em->persist($drive);
            $em->flush();
            $this->addFlash("success", "Ваше объявление добавлено");

            return $this->redirectToRoute('drive_new');
        }

        return $this->render('drive/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="drive_edit", options={"expose"=true}, methods="GET|POST")
     */
    public function edit(Request $request, Drive $drive)
    {
        $form = $this->createForm(DriveNewType::class, $drive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Ваше объявление обновлено");

            return $this->redirectToRoute('drive_edit', [
                'id' => $drive->getId()
            ]);
        }

        return $this->render('drive/edit.html.twig', [
            'drive' => $drive,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/delete", name="drive_delete", methods="DELETE")
     */
    public function delete(Request $request, Drive $drive)
    {
        if ($this->isCsrfTokenValid('delete'.$drive->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($drive);
            $em->flush();
        }

        return $this->redirectToRoute('client_company_index');
    }
}