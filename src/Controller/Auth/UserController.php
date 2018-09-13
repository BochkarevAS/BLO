<?php

namespace App\Controller\Auth;

use App\Entity\Client\Favorite;
use App\Repository\Client\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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

        dump($user->getFavorites()->toArray());

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
     * Добавление в избранное
     *
     * @Route("/{product}/favorite/{type}/add", name="auth_user_add_favorite", options={"expose"=true}, methods="GET|POST")
     */
    public function addFavorite(Request $request, $product, $type)
    {
        $user = $this->getUser();

        if (null === $product || null === $type) {
            throw new BadRequestHttpException('Invalid JSON');
        }

        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();

            $favorite = new Favorite();
            $favorite->setUser($user);
            $favorite->setProduct($product);
            $favorite->setType($type);

            $em->persist($favorite);
            $em->flush();

            return new JsonResponse(null, 200);
        }

        return new JsonResponse(null, 400);
    }

    /**
     * Показать объявления
     *
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