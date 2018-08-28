<?php

namespace App\Controller\Parts;

use App\Dto\Parts\SearchDTO;
use App\Entity\Parts\Engine;
use App\Entity\Parts\Mark;
use App\Entity\Parts\Part;
use App\Form\Parts\PartNewType;
use App\Form\Parts\PartType;
use App\Service\FileUploader;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/part")
 */
class PartsController extends AbstractController
{
//    private $finder;
//
//    public function __construct(PaginatedFinderInterface $finder)
//    {
//        $this->finder = $finder;
//    }

    /**
     * @Route("/", name="part_index", options={"expose"=true})
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

            $query = $this->getDoctrine()->getRepository(Part::class)->search($part, $searchDTO);

            if ($query) {
                $parts = $paginator->paginate($query, $request->query->getInt('page', 1), 20);
            }
        }

        return $this->render('part/index.html.twig', [
            'parts' => $parts,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="part_show", methods="GET")
     */
    public function show(Part $part): Response
    {
        return $this->render('part/show.html.twig', [
            'part' => $part
        ]);
    }

    /**
     * @Route("/new", name="part_new", options={"expose"=true}, methods="GET|POST")
     */
    public function new(Request $request, FileUploader $fileUploader)
    {
        $part = new Part();
        $user = $this->getUser();
        $targetDirectory = $this->getParameter('images_directory');

        $form = $this->createForm(PartNewType::class, $part);
        $form->handleRequest($request);

        if (!$request->isXmlHttpRequest() && $form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $files = $fileUploader->uploadMultiple($part->getImage(), $targetDirectory);
            $json = json_encode($files);
            $part->setImage($json);
            $part->setUser($user);
            $mark = $em->getRepository(Mark::class)->findOneBy(['name' => $part->getMark()]);
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

            dump($part);

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