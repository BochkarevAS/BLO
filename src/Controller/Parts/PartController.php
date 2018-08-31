<?php

namespace App\Controller\Parts;

use App\Dto\Parts\SearchDTO;
use App\Entity\Parts\Comment;
use App\Entity\Parts\Mark;
use App\Entity\Parts\Part;
use App\Form\Parts\CommentType;
use App\Form\Parts\PartNewType;
use App\Form\Parts\PartType;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/part")
 */
class PartController extends AbstractController
{
//    private $finder;
//
//    public function __construct(PaginatedFinderInterface $finder)
//    {
//    }
//        $this->finder = $finder;

    /**
     * @Route("/", name="part_index", methods="GET|POST", options={"expose"=true})
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $part = new Part();
        $form = $this->createForm(PartType::class, $part, ['method' => 'GET']);
        $form->handleRequest($request);
        $parts = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $request->query->get('part');

            $searchDTO = new SearchDTO();

            if (isset($search['oem'])) {
                $searchDTO->setOem($search['oem']);
            }

            if (isset($search['engine'])) {
                $searchDTO->setEngine($search['engine']);
            }

            $parts = $this->getDoctrine()->getRepository(Part::class)->search($part, $searchDTO);

            if (null !== $parts) {
                $parts = $paginator->paginate($parts, $request->query->getInt('page', 1), 20);
            }
        }

        return $this->render('part/index.html.twig', [
            'parts' => $parts,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/show", name="part_show", methods="GET|POST")
     */
    public function show(Request $request, Part $part): Response
    {
        $comment = new Comment();
        $user = $this->getUser();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $comment->setUser($user);
            $comment->setPart($part);
            $comment->setApproved(true);
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('part_show', [
                'id' => $part->getId()
            ]);
        }

        return $this->render('part/show.html.twig', [
            'part' => $part,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="part_new", options={"expose"=true}, methods="GET|POST")
     */
    public function new(Request $request)
    {
        $part = new Part();
        $user = $this->getUser();

        $form = $this->createForm(PartNewType::class, $part);
        $form->handleRequest($request);

        if (!$request->isXmlHttpRequest() && $form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $mark = $em->getRepository(Mark::class)->findOneBy(['name' => $part->getMark()]);
            $part->setUser($user);
            $part->setMark($mark);

            $engines = $part->getEngines()->toArray();
            $oems = $part->getOems()->toArray();

            $hash = md5(
                $this->getUser() .
                $part->getName() .
                $part->getBrand() .
                $part->getModel() .
                $part->getCarcase() .
                $part->getCity() .
                $part->getImage() .
                $part->getAvailability() .
                $part->getCondition() .
                $part->getMark() .
                json_encode($engines) .
                json_encode($oems)
            );

            $part->setHash($hash);

            $em->persist($part);
            $em->flush();
            $this->addFlash("success", "Ваше объявление добавлено");

//            return $this->redirectToRoute('part_new');
        }

        return $this->render('part/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/suggest", name="parts_suggest", options={"expose"=true})
     */
//    public function autocomplete(Request $request)
//    {
//        $query = $request->get('query', null);
//        $data = [];
//
//        $boolQuery  = new \Elastica\Query\BoolQuery();
//        $multiMatch = new \Elastica\Query\MultiMatch();
//        $multiMatch->setFields(['name']);
//        $multiMatch->setType('phrase_prefix');
//        $multiMatch->setQuery($query);
//        $boolQuery->addMust($multiMatch);
//
//        $results = $this->finder->find($boolQuery, 10);
//
//        foreach ($results as $result) {
//            $data[] = $result->getName();
//        }
//
//        return new JsonResponse($data, 200);
//    }
}