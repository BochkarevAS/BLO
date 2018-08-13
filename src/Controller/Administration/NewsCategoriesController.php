<?php

namespace App\Controller\Administration;

use App\Entity\Administration\NewsCategories;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/news_categories")
 */
class NewsCategoriesController extends Controller
{
    /**
     * @Route("/", name="news_categories_render")
     */
    public function renderNews(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $newsCategories = $em->getRepository(NewsCategories::class)->createQueryBuilder('categories')->getQuery();

        $categories = $paginator->paginate(
            $newsCategories,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('administration/news_categories.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/delete/{id}", name="news_categories_delete")
     */
    public function deleteNews($id)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(NewsCategories::class)->find($id);

        if (!$categories) {
            throw $this->createNotFoundException('No news categories found for id ' . $id);
        }

        $em->remove($categories);
        $em->flush();

        return $this->redirectToRoute('news_categories_render');
    }

}