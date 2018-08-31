<?php

namespace App\Controller\Drives;

use App\Entity\Drives\Drive;
use App\Form\Drives\DriveType;
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
     * @Route("/", name="drive_index", methods="GET|POST")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $drive = new Drive();
        $form = $this->createForm(DriveType::class, $drive, ['method' => 'GET']);
        $form->handleRequest($request);
        $drives = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $drives = $this->getDoctrine()->getRepository(Drive::class)->search($drives);

            if (null !== $drives) {
                $drives = $paginator->paginate($drives, $request->query->getInt('page', 1), 20);
            }
        }

        return $this->render('drive/index.html.twig', [
            'drives' => $drives,
            'form'   => $form->createView()
        ]);
    }

}