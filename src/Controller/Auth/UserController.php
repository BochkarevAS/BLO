<?php

namespace App\Controller\Auth;

use App\Entity\Auth\User;
use App\Form\Auth\UserType;
use App\Repository\Client\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/{id}/index", name="client_user_index", options={"expose"=true})
     */
    public function index(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest()) {

            return $this->render('client/user/index.html.twig', [
                'user' => $user,
                'form' => $form->createView()
            ]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_user_index', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('client/user/index.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/all/tyre", name="client_user_index_show_all_tyre", methods={"GET"})
     */
    public function showAllTyre(UserRepository $repository)
    {
        $user = $this->getUser();

        return $this->render('client/user/show_all_tyre.html.twig', [
            'tyres' => $repository->findAllTyre($user)
        ]);
    }

    /**
     * @Route("/show/all/drive", name="client_user_index_show_all_drive", methods={"GET"})
     */
    public function showAllDrive(UserRepository $repository)
    {
        $user = $this->getUser();

        return $this->render('client/user/show_all_drive.html.twig', [
            'drives' => $repository->findAllDrive($user)
        ]);
    }
}