<?php

namespace App\Controller\Administration;

use App\Entity\Administration\News;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{

    /**
     * @Route("/news", name="news_render")
     */
    public function renderNews(Request $request, PaginatorInterface $paginator)
    {
        $newsAll = $this->getDoctrine()->getRepository(News::class)->findAll();

        $news = $paginator->paginate(
            $newsAll,
            $request->query->getInt('page', 1),
            1
        );

        return $this->render('administration/news.html.twig', [
            'news' => $news
        ]);
    }
}