<?php

namespace App\Controller\Auth;

use App\Repository\Client\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auth/user")
 */
class UserController extends AbstractController
{
    /**
     * Доступ в личный кабинет
     *
     * @Route("/personal", name="auth_user_personal", options={"expose"=true})
     */
    public function personal()
    {
        $user = $this->getUser();

        return $this->render('client/user/personal.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/declaration", name="auth_user_declaration", methods={"GET"})
     */
    public function declaration()
    {
        $user = $this->getUser();

        return $this->render('client/user/declaration.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/show/declaration", name="auth_user_show_declaration", methods={"GET"})
     */
    public function showDeclaration(UserRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        $user = $this->getUser();
        $declarations = $repository->findAllDeclaration($user);

        if (null !== $declarations) {
            $declarations = $paginator->paginate($declarations, $request->query->getInt('page', 1), 20);
        }

        return $this->render('client/user/show_declaration.html.twig', [
            'declarations' => $declarations
        ]);
    }

    /**
     * @Route("/show/tyre", name="auth_user_show_tyre", methods={"GET"})
     */
    public function showAllTyre(UserRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        $user = $this->getUser();
        $tyres = $repository->findAllTyre($user);

        if (null !== $tyres) {
            $tyres = $paginator->paginate($tyres, $request->query->getInt('page', 1), 20);
        }

        return $this->render('client/user/show_tyre.html.twig', [
            'tyres' => $tyres,
            'user'  => $user
        ]);
    }

    /**
     * @Route("/show/drive", name="auth_user_show_drive", methods={"GET"})
     */
    public function showAllDrive(UserRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        $user = $this->getUser();
        $drives = $repository->findAllDrive($user);

        if (null !== $drives) {
            $drives = $paginator->paginate($drives, $request->query->getInt('page', 1), 20);
        }

        return $this->render('client/user/show_drive.html.twig', [
            'drives' => $drives,
            'user'   => $user
        ]);
    }
}