<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Tyre\TyreType;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tyre")
 */
class TyreController extends AbstractController
{
    /**
     * @var FileUploader
     */
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * @Route("/", name="tyre_index", methods="GET|POST")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $data = new TyreDto();
        $form = $this->createForm(TyreType::class, $data, ['method' => 'GET']);
        $form->handleRequest($request);
        $tyres = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $tyres = $this->getDoctrine()->getRepository(Tyre::class)->search($data);

            if (null !== $tyres) {
                $tyres = $paginator->paginate($tyres, $request->query->getInt('page', 1), 20);
            }
        }

        return $this->render('product/tyre/index.html.twig', [
            'tyres'    => $tyres,
            'metrics'  => $data->metrics,
            'user'     => $this->getUser(),
            'settings' => $data->settings,
            'form'     => $form->createView()
        ]);
    }

    /**
     * @Route("/create", name="tyre_create",  methods="GET|POST")
     */
    public function create(Request $request)
    {
        $data = new TyreDto();
        $form = $this->createForm(TyreCreateType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /** @var array $type['type'] -> или 'profile' или 'workspace' */
            $type = $request->query->all();

            /**
             * Можно зделать фабрику ...
             * Подумай о том как всё можно занести под метод Tyre::transform я имею ввиду:
             * $data->company
             * $data->user
             * $data->images
             */
            if ('workspace' === $type['type']) {
                $data->company = $em->getRepository(Company::class)->find($type['id']);
            } else {
                $data->user = $this->getUser();
            }

            $data->images = $this->uploader->uploadMultiple($data->images);

            $tyre = Tyre::transform($data);

            $em->persist($tyre);
            $em->flush();
            $this->addFlash("success", "Ваше объявление добавлено");

            return $this->redirectToRoute('tyre_create');
        }

        return $this->render('product/tyre/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/settings", name="tyre_settings",  methods="GET|POST")
     */
    public function edit(Request $request, Tyre $tyre)
    {
        $data = TyreDto::createFromEntity($tyre);
        $form = $this->createForm(TyreCreateType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (current($data->images) instanceof UploadedFile) {
                $data->images = $this->uploader->uploadMultiple($data->images);
            }

            /**
             * Можно подумать про отдельный класс transform ...
             */
            $tyre = $tyre->transform($data);

            $em = $this->getDoctrine()->getManager();
            $em->merge($tyre);
            $em->flush();
            $this->addFlash("success", "Ваше объявление обновлено");

            return $this->redirectToRoute('tyre_settings', [
                'id' => $tyre->getId()
            ]);
        }

        return $this->render('product/tyre/edit.html.twig', [
            'user' => $this->getUser(),
            'tyre' => $tyre,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="tyre_delete", methods="DELETE")
     */
    public function delete(Request $request, Tyre $tyre)
    {
        if ($this->isCsrfTokenValid('delete' . $tyre->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tyre);
            $em->flush();
        }

        return $this->redirectToRoute('auth_user_personal');
    }
}