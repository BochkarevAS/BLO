<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\PartDto;
use App\Entity\Parts\Brand;
use App\Entity\Parts\Engine;
use App\Entity\Parts\Frame;
use App\Entity\Parts\Model as ModelPart;
use App\Entity\Parts\Part;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Enqueue\Util\JSON;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View as View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ApiPartController extends AbstractFOSRestController implements ClassResourceInterface
{
    private $uploader;

    private $em;

    public function __construct(FileUploader $uploader, EntityManagerInterface $em)
    {
        $this->uploader = $uploader;
        $this->em       = $em;
    }

    /**
     * @Rest\Get("part/{id}/render")
     * @SWG\Response(
     *     response=200,
     *     description="Получение запчасти по id",
     *     @Model(type=PartDTO::class)
     * )
     * @Rest\View()
     */
    public function findById(Part $part)
    {
        $dto = PartDto::transform($part);

        return $dto;
    }

    /**
     * @Rest\Get("part/brand", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Получение всех брэндов",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Brand::class, groups={"full"}))
     *     )
     * )
     *  @Rest\View()
     */
    public function getBrand()
    {
        $brands = $this->getDoctrine()->getRepository(Brand::class)->findAllBrand();

        if (null == $brands) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $brands;
    }

    /**
     * @Rest\Get("part/{id}/model", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Получение моделй по id брэнда",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=ModelPart::class, groups={"full"}))
     *     )
     * )
     *  @Rest\View()
     */
    public function getModel(int $id)
    {
        $models = $this->getDoctrine()->getRepository(ModelPart::class)->findByBrand($id);

        if (null == $models) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $models;
    }

    /**
     * @Rest\Get("part/relation", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Получение кузавов и двигателей по ids моделей",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=ModelPart::class, groups={"full"}))
     *     )
     * )
     *  @Rest\View()
     */
    public function getRelation(Request $request)
    {
        $params = $request->query->all();

        $params = array_map(function($value) {
            return JSON::decode($value);
        }, $params);

        $params = array_column($params, 'value');
        $models = $this->getDoctrine()->getRepository(ModelPart::class)->findByArray($params);

        if (null == $models) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        $json = [];

        foreach ($models as $model) {

            /** @var Frame $entity */
            foreach ($model->getFrames() as $entity) {
                $json['frames'][] = ['value' => $entity->getId(), 'label' => $entity->getName()];
            }

            /** @var Engine $entity */
            foreach ($model->getEngines() as $entity) {
                $json['engines'][] = ['value' => $entity->getId(), 'label' => $entity->getName()];
            }
        }

        return $json;
    }

    /**
     * @Rest\Get("part/catalog", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Получение всего каталога",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Catalog::class, groups={"full"}))
     *     )
     * )
     *  @Rest\View()
     */
    public function getCatalog()
    {
        $catalog = $this->getDoctrine()->getRepository(Catalog::class)->findAllCatalog();

        if (null == $catalog) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $catalog;
    }

    /**
     * @Rest\Post("part/create")
     * @SWG\Response(
     *     response=204,
     *     description="Создание объявление для запчастей"
     * )
     * @SWG\Parameter(
     *     name="JSON update body",
     *     in="body",
     *     description="Создание объявление для запчастей",
     *     required=true,
     *     @Model(type=PartDto::class)
     * )
     * @Rest\View()
     * @ParamConverter(name="dto", converter="data_transfer_object")
     */
    public function create(PartDto $dto)
    {
        $part = new Part();
        $part = Part::transform($dto, $part, $this->em, $this->uploader);

        $this->em->persist($part);
        $this->em->flush();
    }

    /**
     * @Rest\Put("part/{id}/update")
     * @SWG\Response(
     *     response=201,
     *     description="Редатирование объявление для запчастей"
     * )
     * @SWG\Parameter(
     *     name="JSON update body",
     *     in="body",
     *     description="Редатирование объявление для запчастей",
     *     required=true,
     *     @Model(type=PartDto::class)
     * )
     * @Rest\View()
     * @ParamConverter("dto", converter="fos_rest.request_body")
     */
    public function update(PartDto $dto, Part $part, Request $request)
    {
        $part = Part::transform($dto, $part, $this->em, $this->uploader);

        $this->em->persist($part);
        $this->em->flush();
    }

    /**
     * @Rest\POST("part/file")
     * @SWG\Response(
     *     response=204,
     *     description="Загруска файлов"
     * )
     * @SWG\Parameter(
     *     name="file",
     *     in="body",
     *     description="Загруска файлов",
     *     type="file",
     *     required=true
     * )
     * @Rest\View()
     */
    public function fileUpload(Request $request)
    {
        $file = $request->files->get('images');

        if ($file instanceof UploadedFile) {
            $this->uploader->upload($file);
        }
    }
}