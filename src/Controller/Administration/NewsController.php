<?php

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
        $newsAll = $this->getDoctrine()->getRepository(News::class)->findAll();

        $news = $paginator->paginate(
            $newsAll,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('administration/news.html.twig', [
            'news' => $news
        ]);
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
        $em = $this->getDoctrine()->getManager();

        $params = $request->request->all();

        $news = new News();
        $news->setName($params['name']);
        $news->setImg($params['img']);
        $news->setUrl($params['url']);
        $news->setTitle($params['title']);
        $news->setCompany($params['company']);
        $news->setUid($params['uid']);
        $news->setDisplay($params['display']);
        $news->setDisplayOnMain($params['display_on_main']);
        $news->setTypeNews($params['type_news']);
        $news->setCreatedAt();

        dump($params);
        return new Response('<html><body>ttt</body></html>');

        die;


//        $em->remove($news);
//        $em->flush();

        return $this->redirectToRoute('news_render');
    }
}