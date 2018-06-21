<?php

namespace App\Controller\Part;

use App\Entity\Part\Model;
use App\Form\Part\ModelType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PartController extends AbstractController
{
    /**
     * @Route("/part", name="part_render")
     */
    public function renderPart(Request $request, PaginatorInterface $paginator)
    {
        $model = new Model();
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($model);
            $em->flush();
        }

//        $search = $request->query->get('part');
        $spares = false;
//
//        dump($search);
//
//        if ($search) {
//            $em = $this->getDoctrine()->getManager();
//            $query = $em->getRepository(Model::class)->search($search);
//
//            if ($query) {
//                $spares = $paginator->paginate(
//                    $query,
//                    $request->query->getInt('page', 1),
//                    5
//                );
//            }
//        }

        return $this->render('spare/render.html.twig', [
            'spares' => $spares,
            'form'   => $form->createView()
        ]);
    }

    /**
     * @Route("/part/ajax/call", name="part_ajax_call", options={"expose"=true})
     */
    public function ajaxAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        $id = $request->query->get('part_id');
        $list = [];

        $repo = $this->getDoctrine()->getManager()->getRepository(Model::class);
        $brands = $repo->findBy(['brand' => $id]);

        foreach ($brands as $brand) {
            $list[$brand->getName()] = $brand->getId();
        }

        $json = $this->get('serializer')->serialize($list, 'json');

        return new JsonResponse($json, 200, [], true);
    }
}