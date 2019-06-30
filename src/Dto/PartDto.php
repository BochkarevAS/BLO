<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Parts\Part;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @SWG\Definition()
 */
class PartDto
{
    /**
     * @SWG\Property(
     *     type="object",
     *     description="Производитель",
     *     @SWG\Property(property="value", type="integer", example="1"),
     *     @SWG\Property(property="label", type="string", example="toyota")
     * )
     * @Type("array")
     */
    public $brand;

    /**
     * @SWG\Property(
     *     type="array",
     *     description="Модели",
     *     @SWG\Items(
     *          type="object",
     *          @SWG\Property(property="value", type="integer", example="1"),
     *          @SWG\Property(property="label", type="string", example="camry")
     *     )
     * )
     * @Type("array")
     */
    public $models;

    /**
     * @SWG\Property(
     *     type="array",
     *     description="Двигателя",
     *     @SWG\Items(
     *          type="object",
     *          @SWG\Property(property="value", type="integer", example="1"),
     *          @SWG\Property(property="label", type="string", example="mx-100")
     *     )
     * )
     * @Type("array")
     */
    public $engines;

    /**
     * @SWG\Property(
     *     type="array",
     *     description="Кузова",
     *     @SWG\Items(
     *          type="object",
     *          @SWG\Property(property="value", type="integer", example="1"),
     *          @SWG\Property(property="label", type="string", example="epew")
     *     )
     * )
     * @Type("array")
     */
    public $frames;

    /**
     * @SWG\Property(
     *     type="string",
     *     example="16470-20031"
     * )
     * @Type("string")
     */
    public $oem;

    /**
     * @SWG\Property(
     *     type="object",
     *     description="Название запчасти",
     *     @SWG\Property(property="value", type="integer", example="1"),
     *     @SWG\Property(property="label", type="string", example="фарсунка")
     * )
     * @Type("array")
     */
    public $name;

    /**
     * @SWG\Property(type="string")
     * @Type("string")
     */
    public $marking;

    /**
     * @SWG\Property(
     *     type="object",
     *     description="Город",
     *     @SWG\Property(property="value", type="integer", example="1"),
     *     @SWG\Property(property="label", type="string", example="Арсеньев")
     * )
     * @Type("array")
     */
    public $city;

    /**
     * @SWG\Property(type="string")
     * @Type("string")
     */
    public $availability;

    /**
     * @SWG\Property(type="string")
     * @Type("string")
     */
    public $condition;

    /**
     * @SWG\Property(type="string")
     * @Type("string")
     */
    public $price;

    /**
     * @SWG\Property(
     *     type="object",
     *     description="Изображения"
     * )
     * @Type("array")
     */
    public $images;

    /**
     * @SWG\Property(type="string")
     * @Type("string")
     */
    public $ud;

    /**
     * @SWG\Property(type="string")
     * @Type("string")
     */
    public $fr;

    /**
     * @SWG\Property(type="string")
     * @Type("string")
     */
    public $rl;

    /**
     * @SWG\Property(type="string")
     * @Type("string")
     */
    public $declaration;

    /**
     * @SWG\Property(type="string")
     * @Type("string")
     */
    public $address;

    /**
     * @SWG\Property(type="boolean")
     * @Type("boolean")
     * @SerializedName("deliveryCity")
     */
    public $deliveryCity;

    /**
     * @SWG\Property(type="boolean")
     * @Type("boolean")
     * @SerializedName("deliveryCompany")
     */
    public $deliveryCompany;

    /**
     * @SWG\Property(type="boolean")
     * @Type("boolean")
     * @SerializedName("deliveryPost")
     */
    public $deliveryPost;

    /**
     * @SWG\Property(type="string")
     * @Type("string")
     * @SerializedName("deliveryPayment")
     */
    public $deliveryPayment;

    /**
     * @SWG\Property(type="integer")
     * @Type("integer")
     */
    public $company;

    /**
     * @SWG\Property(type="integer")
     * @Type("integer")
     */
    public $user;

    /**
     * @SWG\Property(type="string")
     * @Type("string")
     */
    public $year;
    public $priceFrom;

    public $priceTo;

    public $hash;

    /**
     * Флаг для редактирования. Тоесть если true значит запчасти редактируются.
     */
    public $settings;

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        $this->priceFrom = intval($this->priceFrom);
        $this->priceTo   = intval($this->priceTo);

        if ($this->priceFrom > $this->priceTo) {
            $context->buildViolation('Цена до не может быть меньши цены от')
                ->atPath('priceTo')
                ->addViolation();
        }
    }

    public static function transform(Part $part): self
    {
        $dto = new self();

        if (!empty($part->getBrand())) {
            $dto->brand = [
                'value' => $part->getBrand()->getId(),
                'label' => $part->getBrand()->getName()
            ];
        }

        if (!empty($part->getModels())) {
            foreach ($part->getModels() as $model) {
                $dto->models[] = [
                    'value' => $model->getId(),
                    'label' => $model->getName()
                ];
            }
        }

        if (!empty($part->getFrames())) {
            foreach ($part->getFrames() as $frame) {
                $dto->frames[] = [
                    'value' => $frame->getId(),
                    'label' => $frame->getName()
                ];
            }
        }

        if (!empty($part->getEngines())) {
            foreach ($part->getEngines() as $engine) {
                $dto->engines[] = [
                    'value' => $engine->getId(),
                    'label' => $engine->getName()
                ];
            }
        }

        if (!empty($part->getCity())) {
            $dto->city = [
                'value' => $part->getCity()->getId(),
                'label' => $part->getCity()->getName()
            ];
        }

        if (!empty($part->getName())) {
            $dto->name = [
                'value' => $part->getId(),
                'label' => $part->getName()
            ];
        }

        if (!empty($part->getName())) {
            $dto->name = [
                'value' => $part->getId(),
                'label' => $part->getName()
            ];
        }

        if (!empty($part->getCompany())) {
            /** @var Company $company */
            $company = $part->getCompany();
            $dto->company = $company->getId();
        }

        if (!empty($part->getUser())) {
            /** @var User $user */
            $user = $part->getUser();
            $dto->user = $user->getId();
        }

        $dto->oem             = $part->getOem();
        $dto->marking         = $part->getMarking();
        $dto->ud              = $part->getUd();
        $dto->fr              = $part->getFr();
        $dto->rl              = $part->getRl();
        $dto->year            = $part->getYear();
        $dto->availability    = $part->getAvailability();
        $dto->condition       = $part->getCondition();
        $dto->declaration     = $part->getDeclaration();
        $dto->address         = $part->getAddress();
        $dto->deliveryCity    = $part->getDeliveryCity();
        $dto->deliveryCompany = $part->getDeliveryCompany();
        $dto->deliveryPost    = $part->getDeliveryPost();
        $dto->deliveryPayment = $part->getDeliveryPayment();
        $dto->price           = $part->getPrice();
        $dto->images          = $part->getImages();

        return $dto;
    }
}
