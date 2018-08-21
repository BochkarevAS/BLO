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
    protected $fileUploader;

    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    /**
     * @Route("/{id}/edit", name="client_user_edit", methods="GET|POST", options={"expose"=true})
     */
    public function edit(Request $request, User $user)
    {
        $avatar = $user->getAvatar();
        $path = $this->getParameter('logotype_directory').'/'.$avatar;

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileName = $this->fileUploader($user);
            $user->setAvatar($fileName);

            if (file_exists($path) && $avatar) {
                unlink($path);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_user_edit', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('client/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    private function fileUploader(User $user)
    {
        $targetDirectory = $this->getParameter('logotype_directory');
        $fileName = $this->fileUploader->upload($user->getAvatar(), $targetDirectory);

        return $fileName;
    }
}