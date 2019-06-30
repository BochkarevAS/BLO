<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\PartDto;
use App\Entity\Parts\Part;
use App\Service\FileUploader;
use FOS\ElasticaBundle\Doctrine\RepositoryManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/part")
 */
class PartController extends AbstractController
{
    /**
     * @var RepositoryManager
     */
    private $manager;

    /**
     * @var FileUploader
     */
    private $uploader;

    public function __construct(FileUploader $uploader, RepositoryManager $manager)
    {
        $this->manager  = $manager;
        $this->uploader = $uploader;
    }

    /**
     * @Route("/", name="part_index", methods="GET|POST", options={"expose"=true})
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $data = new PartDto();
        $form = $this->createForm(PartType::class, $data, ['method' => 'GET']);
        $form->handleRequest($request);

        $parts = null;

        /**
         * $request->isXmlHttpRequest() плохое API
         */
        if (!$request->isXmlHttpRequest() && $form->isSubmitted() && $form->isValid()) {
            $parts = $this->manager->getRepository(Part::class)->searchPart($data);

            if (null !== $parts) {
                $parts = $paginator->paginate($parts, $request->query->getInt('page', 1), 20);
            }
        }

        return $this->render('part/index.html.twig', [
            'parts' => $parts,
            'form'  => $form->createView()
        ]);
    }
}