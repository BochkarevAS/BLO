<?php

namespace App\Controller\Part;

use App\Entity\Part\Model;
use App\Form\Part\PartType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PartController extends AbstractController
{
    /**
     * @Route("/part", name="part_render")
     */
    public function renderPart(Request $request, PaginatorInterface $paginator)
    {
        $form = $this->createForm(PartType::class);
        $search = $request->query->get('part');
        $spares = false;

        dump($search);

        if ($search) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->getRepository(Model::class)->search($search);

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
}