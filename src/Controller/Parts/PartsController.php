<?php

namespace App\Controller\Parts;

use App\Dto\Parts\SearchDTO;
use App\Entity\Parts\Part;
use App\Form\Parts\PartType;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/parts")
 */
class PartsController extends AbstractController
{
    private $finder;

    public function __construct(PaginatedFinderInterface $finder)
    {
        $this->finder = $finder;
    }

    /**
     * @Route("/", name="parts_index", options={"expose"=true})
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $part = new Part();
        $form = $this->createForm(PartType::class, $part, ['method' => 'GET']);
        $form->handleRequest($request);
        $parts = null;



        $connection = $this->getDoctrine()->getConnection();
        $statement = $connection->prepare("SELECT id, emails FROM client.user_company1 LIMIT 5");
//        $statement->bindValue('id', 123);
        $statement->execute();
        $results = $statement->fetchAll();



        foreach ($results as $email) {

            $pattern = "/[-a-z0-9!#$%&'*_`{|}~]+[-a-z0-9!#$%&'*_`{|}~\.=?]*@[a-zA-Z0-9_-]+[a-zA-Z0-9\._-]+/i";
            preg_match_all($pattern, $email['emails'], $result);

            $r = array_unique(array_map(function ($i) { return $i; }, [$email['id'] => $result]));
//            dump($r);

            foreach ($r as $id => $emails) {
                array_walk_recursive($emails, function ($item, $key) use ($id) {

                    dump($id);
                    dump($item);
                });
            }


//            array_walk_recursive($r, function ($item, $key) {
//
//                dump($key);
//                dump($item);
////                echo $item."\n";
//            });

//            $array = explode('\\', $email['emails']);
//
//            dump($array);
        }




        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();
            $search = $request->query->get('part');

            $searchDTO = new SearchDTO();

            if (isset($search['model'])) {
                $searchDTO->setModel($search['model']);
            }

            if (isset($search['carcase'])) {
                $searchDTO->setCarcase($search['carcase']);
            }

            $query = $this->getDoctrine()->getRepository(Part::class)-> search($entity, $searchDTO);

            if ($query) {
                $parts = $paginator->paginate($query, $request->query->getInt('page', 1), 20);
            }
        }

        return $this->render('parts/parts_render.html.twig', [
            'parts' => $parts,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/suggest", name="parts_suggest", options={"expose"=true})
     */
    public function autocomplete(Request $request)
    {
        $query = $request->get('query', null);
        $data = [];

        $boolQuery  = new \Elastica\Query\BoolQuery();
        $multiMatch = new \Elastica\Query\MultiMatch();
        $multiMatch->setFields(['name']);
        $multiMatch->setType('phrase_prefix');
        $multiMatch->setQuery($query);
        $boolQuery->addMust($multiMatch);

        $results = $this->finder->find($boolQuery, 10);

        foreach ($results as $result) {
            $data[] = $result->getName();
        }

        return new JsonResponse($data, 200);
    }
}