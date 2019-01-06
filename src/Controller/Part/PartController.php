<?php

namespace App\Controller;

use App\Dto\CommentDto;
use App\Dto\PartDto;
use App\Entity\Parts\Comment;
use App\Entity\Parts\Engine;
use App\Entity\Parts\Frame;
use App\Entity\Parts\Model;
use App\Entity\Parts\Part;
use App\Form\Client\CommentType;
use App\Form\Part\PartCreateType;
use App\Form\Part\PartType;
use App\Service\FileUploader;
use FOS\ElasticaBundle\Doctrine\RepositoryManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    /**
     * @Route("/relation", name="part_relation", methods={"GET"}, options={"expose"=true})
     */
    public function relation(Request $request)
    {
        $relation = [];
        $modelId  = $request->query->get('modelId');

        if ($modelId) {
            $model = $this->getDoctrine()->getRepository(Model::class)->find($modelId);

            if ($model) {

                /** @var Frame $entity */
                foreach ($model->getFrames() as $entity) {
                    $relation['frames'][] = $entity->getName();
                }

                /** @var Engine $entity */
                foreach ($model->getEngines() as $entity) {
                    $relation['engines'][] = $entity->getName();
                }
            }
        }

        return new JsonResponse($relation, 200);
    }

    /**
     * @Route("/show/all", name="part_show_all", methods={"GET"})
     */
    public function showAllPart(Request $request, PaginatorInterface $paginator)
    {
        $user  = $this->getUser();
        $parts = $this->getDoctrine()->getRepository(Part::class)->findAllPart($user);

        if (null !== $parts) {
            $parts = $paginator->paginate($parts, $request->query->getInt('page', 1), 20);
        }

        return $this->render('client/user/show_part.html.twig', [
            'parts' => $parts,
            'user'  => $user
        ]);
    }

    /**
     * @Route("/{id}/show", name="part_show", methods="GET|POST")
     */
    public function show(Request $request, Part $part)
    {
        $data = new CommentDto();
        $form = $this->createForm(CommentType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data->product = $part;
            $data->user    = $this->getUser();

            $comment = Comment::createFromDto($data);

            $em = $this->getDoctrine()->getManager();
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
     * @Route("/create", name="part_create", options={"expose"=true}, methods="GET|POST")
     */
    public function create(Request $request)
    {
        $data = new PartDto();
        $form = $this->createForm(PartCreateType::class, $data);
        $form->handleRequest($request);

        $data->user = $this->getUser();

        if (!$request->isXmlHttpRequest() && $form->isSubmitted() && $form->isValid()) {
            $data->images = $this->uploader->uploadMultiple($data->images);

            $part = Part::createFromDto($data);

            $em = $this->getDoctrine()->getManager();
            $em->persist($part);
            $em->flush();

            $this->addFlash("success", "Ваше объявление добавлено");

            return $this->redirectToRoute('part_create');
        }

        return $this->render('part/create.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="part_edit", options={"expose"=true}, methods="GET|POST")
     */
    public function edit(Request $request, Part $part)
    {
        $data = PartDto::createFromEntity($part);
        $form = $this->createForm(PartCreateType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (current($data->images) instanceof UploadedFile) {
                $data->images = $this->uploader->uploadMultiple($data->images);
            }

            $part = $part->updateFromDto($data);

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $em->persist($part);

            $this->addFlash("success", "Ваше объявление обновлено");

            return $this->redirectToRoute('part_edit', [
                'id' => $part->getId()
            ]);
        }

        return $this->render('part/edit.html.twig', [
            'user' => $this->getUser(),
            'part' => $part,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="part_delete", methods="DELETE")
     */
    public function delete(Request $request, Part $part)
    {
        if ($this->isCsrfTokenValid('delete' . $part->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($part);
            $em->flush();
        }

        return $this->redirectToRoute('auth_user_personal');
    }
}