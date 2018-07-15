<?php

namespace App\Controller\Parts;

use App\Entity\Parts\Brand;
use App\Entity\Parts\Carcase;
use App\Entity\Parts\Model;
use App\Entity\Parts\Oem;
use App\Entity\Parts\Part;
use App\Form\Parts\BrandType;
use App\Form\Parts\OemType;
use App\Form\Parts\PartType;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PartsController extends AbstractController
{
    /**
     * @Route("/parts", name="parts_render", options={"expose"=true})
     */
    public function renderParts(Request $request, PaginatorInterface $paginator)
    {
        $brand = new Brand();
        $form = $this->createForm(BrandType::class, $brand, ['method' => 'GET']);


//        $oem = new Oem();
//        $form = $this->createForm(OemType::class, $oem, ['method' => 'GET']);

        $form->handleRequest($request);
        $oems = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();

            dump($entity);


//            $entity->setCity($form->get('city')->getData());
//            $query = $this->getDoctrine()->getRepository(Oem::class)->search($entity);
//
//            if ($query) {
//                $oems = $paginator->paginate($query, $request->query->getInt('page', 1), 5);
//            }
        }

        return $this->render('parts/parts_render.html.twig', [
            'oems' => $oems,
            'form' => $form->createView()
        ]);
    }
}