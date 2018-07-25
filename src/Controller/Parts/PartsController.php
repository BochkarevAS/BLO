<?php

namespace App\Controller\Parts;

use App\Entity\Parts\Part;
use App\Form\Parts\PartType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/parts")
 */
class PartsController extends AbstractController
{
    /**
     * @Route("/", name="parts_index", options={"expose"=true})
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $part = new Part();
        $form = $this->createForm(PartType::class, $part, ['method' => 'GET']);
        $form->handleRequest($request);
        $parts = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();
            $entity->setParts($request->query->get('part'));

            $query  = $this->getDoctrine()->getRepository(Part::class)->renderParts($entity);

            if ($query) {
                $parts = $paginator->paginate($query, $request->query->getInt('page', 1), 20);
            }
        }

        return $this->render('parts/parts_render.html.twig', [
            'parts' => $parts,
            'form'  => $form->createView()
        ]);
    }
}