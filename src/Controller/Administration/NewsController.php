<?php

namespace App\Controller\Administration;

use App\Entity\Administration\News;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/news")
 */
class NewsController extends AbstractController
{
    /**
     * @Route("/", name="news_render")
     */
    public function renderNews(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $newsAll = $em->getRepository(News::class)->createQueryBuilder('news')->getQuery();

        $news = $paginator->paginate(
            $newsAll,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('administration/news.html.twig', [
            'news' => $news
        ]);
    }

    /*
     * @Route("/display/{id}", name="new_display", options={"expose"=true})
     */
    public function display($id)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository(News::class)->find($id);

        if (!$news) {
            throw $this->createNotFoundException('No news found for id ' . $id);
        }

        $display = $news->getDisplay();
        $display = ($display == 'no') ? 'yes' : 'no';

        $news->setDisplay($display);

        $em->flush();

        return new Response(null, 204);
    }

    /**
     * @Route("/edit", name="news_edit")
     */
    public function editNews(Request $request)
    {
        $params = $request->request->all();

        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository(News::class)->find($params['id']);

        if (!$news) {
            throw $this->createNotFoundException('No news found for id ' . $params['id']);
        }

        $news->setName($params['name']);
        $news->setImg(1);
        $news->setTitle($params['title']);
        $news->setCompany($params['company']);
        $news->setUid($params['uid']);
        $news->setDisplay($params['display']);
        $news->setDisplayOnMain($params['display_on_main']);
        $news->setTypeNews($params['type_news']);
//        $news->setCreatedAt($params['created_at']);

        $em->flush();

        return $this->redirectToRoute('news_render');
    }

    /**
     * @Route("/delete/{id}", name="news_delete")
     */
    public function deleteNews($id)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository(News::class)->find($id);

        if (!$news) {
            throw $this->createNotFoundException('No news found for id ' . $id);
        }

        $em->remove($news);
        $em->flush();

        return $this->redirectToRoute('news_render');
    }

    /**
     * @Route("/create", name="news_create")
     */
    public function createNews(Request $request)
    {
        $params = $request->request->all();

        $news = new News();
        $news->setName($params['name']);
        $news->setImg('img');
        $news->setTitle($params['name']);
        $news->setCompany($params['company']);
        $news->setUid(1);
        $news->setDisplay(1);
        $news->setDisplayOnMain(1);
        $news->setTypeNews($params['type_news']);
        $news->setCreatedAt($params['created_at']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($news);
        $em->flush();

        return $this->redirectToRoute('news_render');
    }
}