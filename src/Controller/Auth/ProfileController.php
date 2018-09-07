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
     * @Route("/{id}/edit", name="auth_profile_edit", options={"expose"=true})
     */
    public function edit(Request $request, User $user)
    {
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);

        if (!$request->isXmlHttpRequest() && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('auth_profile_edit', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('client/user/index.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}