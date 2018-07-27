<?php

namespace App\Controller\Parts;

use App\Entity\Parts\Part;
use App\Form\Parts\PartType;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Elastica\Query;
use Elastica\Suggest;

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

        $searchQuery = $request->get('query');

        dump($request->get('query'));

        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();
            $entity->setParts($request->query->get('part'));

            $query = $this->getDoctrine()->getRepository(Part::class)->renderParts($entity);

            if (!empty($searchQuery)) {
                $query = $this->finder->createPaginatorAdapter($searchQuery);


                if ($query) {
                    $parts = $paginator->paginate($query, $request->query->getInt('page', 1), 20);
                }
            }

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
    public function getPartsName(Request $request)
    {
        if (!($text = $request->get('q'))) {
            throw new BadRequestHttpException('Missing "q" parameter.');
        }

        $completion = new Suggest\Completion('search', 'name_suggest');
        $completion->setText($text);
        $completion->setFuzzy(['fuzziness' => 2]);
        $result = $this->finder->search(Query::create($completion));
        $suggestions = [];

        foreach ($result->getSuggests() as $suggests) {
            foreach ($suggests as $suggest) {
                foreach ($suggest['options'] as $option) {
                    $suggestions[] = [
                        'id'   => $option['_source']['id'],
                        'text' => $option['_source']['name']
                    ];
                }
            }
        }

        return new JsonResponse(['suggestions' => $suggestions]);
    }
}