<?php

namespace App\Controller\Parts;

use App\Entity\Parts\Carcase;
use App\Entity\Parts\Model;
use App\Entity\Parts\Oem;
use App\Entity\Parts\Part;
use App\Form\Parts\PartType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PartsController extends AbstractController
{
    /**
     * @Route("/parts", name="parts_render")
     */
    public function renderPart(Request $request, PaginatorInterface $paginator)
    {
        $part = new Part();
        $form = $this->createForm(PartType::class, $part, ['method' => 'GET']);
        $form->handleRequest($request);
        $oems = false;

        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();
            $entity->setCity($form->get('city')->getData());
            $em = $this->getDoctrine()->getManager();
            $query = $em->getRepository(Oem::class)->search($entity);

            if ($query) {
                $oems = $paginator->paginate($query, $request->query->getInt('page', 1), 5);
            }
        }

        return $this->render('parts/parts_render.html.twig', [
            'oems' => $oems,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/parts/ajax", name="part_ajax", options={"expose"=true})
     */
    public function ajaxPart(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        $elements = null;
        $list = [];

        if ($id = $request->query->get('model_id')) {
            $elements = $this->getDoctrine()->getRepository(Model::class)->getModelById($id);
        } elseif ($id = $request->query->get('carcase_id')) {
            $elements = $this->getDoctrine()->getRepository(Carcase::class)->getCarcaseById($id);
        }

        foreach ($elements as $element) {
            $list[$element->getName()] = $element->getId();
        }

        $json = $this->get('serializer')->serialize($list, 'json');

        return new JsonResponse($json, 200, [], true);
    }
}