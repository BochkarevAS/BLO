<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\City;
use App\Entity\Department;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View as View;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiCountryController extends AbstractFOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get("department/{id}/region", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Получение всех депортаментов",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Department::class, groups={"full"}))
     *     )
     * )
     *
     *  @Rest\View()
     */
    public function findDepartmentByRegion(int $id)
    {
        $departments = $this->getDoctrine()->getRepository(Department::class)->findDepartmentByRegion($id);

        if (null === $departments) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $departments;
    }

    /**
     * @Rest\Get("department/{id}/city", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Получение всех депортаментов",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=City::class, groups={"full"}))
     *     )
     * )
     *
     *  @Rest\View()
     */
    public function findCityByDepartment(int $id)
    {
        $citys = $this->getDoctrine()->getRepository(City::class)->findCityByDepartment($id);

        if (null === $citys) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $citys;
    }
}