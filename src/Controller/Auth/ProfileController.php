<?php

namespace App\Controller\Auth;

use App\Entity\Auth\User;
use App\Form\Auth\ProfileFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auth/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/edit", name="auth_profile_edit", options={"expose"=true}, methods="GET|POST")
     */
    public function edit(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $user = new User();
            $form = $this->createForm(ProfileFormType::class, $user);
            $form->handleRequest($request);

            return $this->render('client/user/index.html.twig', [
                'user' => $user,
                'form' => $form->createView()
            ]);
        }

        $user = $this->getUser();
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('auth_profile_edit');
        }

        return $this->render('client/user/index.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}