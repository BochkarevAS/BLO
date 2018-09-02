<?php

namespace App\Controller\Drive;

use App\Entity\Drives\Drive;
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
            'form'   => $form->createView()
        ]);
    }

    /**
     * @Route("/show", name="drive_show", methods="GET|POST")
     */
    public function show()
    {
        return $this->render('drive/show.html.twig');
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

}