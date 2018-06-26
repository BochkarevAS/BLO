<?php

namespace App\Controller\Part;

use App\Entity\Parts\Model;
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
        $form = $this->createForm(ModelType::class, $model, ['method' => 'GET']);
        $form->handleRequest($request);
        $spares = false;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $query = $em->getRepository(Model::class)->search($data);

            if ($query) {
                $spares = $paginator->paginate(
                    $query,
                    $request->query->getInt('page', 1),
                    5
                );
            }
        }

        return $this->render('spare/render.html.twig', [
            'spares' => $spares,
            'form'   => $form->createView()
        ]);
    }

    /**
     * @Route("/part/ajax", name="part_ajax", options={"expose"=true})
     */
    public function ajaxPart(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        $elements = null;
        $list = [];

        if ($id = $request->query->get('model_id')) {
            $elements = $this->getDoctrine()->getManager()->getRepository(Model::class)->findBy(['brand' => $id]);
        } elseif ($id = $request->query->get('carcase_id')) {
            $carcases = $this->getDoctrine()->getManager()->getRepository(Model::class)->find($id);
            $elements = $carcases->getCarcases();
        }

        foreach ($elements as $element) {
            $list[$element->getName()] = $element->getId();
        }

        $json = $this->get('serializer')->serialize($list, 'json');

        return new JsonResponse($json, 200, [], true);
    }
}