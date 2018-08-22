<?php

namespace App\Controller\Client;

use App\Entity\Auth\User;
use App\Form\Client\UserType;
use App\Service\FileUploader;
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
    public function index(Request $request, User $user, FileUploader $fileUploader)
    {
        $avatar = $user->getAvatar();
        $targetDirectory = $this->getParameter('images_directory');
        $path = $targetDirectory.'/'.$avatar;

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest()) {

            return $this->render('client/user/index.html.twig', [
                'user' => $user,
                'form' => $form->createView()
            ]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $fileName = $fileUploader->upload($user->getAvatar(), $targetDirectory);
            $user->setAvatar($fileName);

            if (file_exists($path) && $avatar) {
                unlink($path);
            }

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
}