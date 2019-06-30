<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Tyres\Tyre;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class TyreDto
{
    public $id;

    public $brand;

    public $model;

    public $user;

    public $company;

    public $city;

    public $width;

    public $height;

    public $diameter;

    public $widthIn;

    public $heightIn;

    public $diameterIn;

    public $quantity;

    public $year;

    public $protector;

    public $type;

    public $wear;

    /**
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Текст объявления не может быть длиннее {{limit}} символов"
     * )
     */
    public $textDeclaration;

    /**
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Адрес самовывоза не может быть длиннее {{limit}} символов"
     * )
     */
    public $address;

    public $deliveryCity;

    public $deliveryCompany;

    public $deliveryPost;

    /**
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Условия доставки и оплаты не может быть длиннее {{limit}} символов"
     * )
     */
    public $deliveryPayment;

    public $price;

    public $condition;

    public $availability;

    public $hash;

    public $images;

    public $link;

    public $settings;

    public $metrics;

    public $priceFrom;

    public $priceTo;

    public $createdAt;

    public $updatedAt;

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

    public static function transform(Tyre $tyre): self
    {
        $dto = new self();

        $dto->brand           = $tyre->getBrand();
        $dto->model           = $tyre->getModel();
        $dto->user            = $tyre->getUser();
        $dto->company         = $tyre->getCompany();
        $dto->city            = $tyre->getCity();
        $dto->diameter        = $tyre->getDiameter();
        $dto->height          = $tyre->getHeight();
        $dto->width           = $tyre->getWidth();
        $dto->quantity        = $tyre->getQuantity();
        $dto->year            = $tyre->getYear();
        $dto->protector       = $tyre->getProtector();
        $dto->type            = $tyre->getType();
        $dto->availability    = $tyre->getAvailability();
        $dto->wear            = $tyre->getWear();
        $dto->textDeclaration = $tyre->getTextDeclaration();
        $dto->address         = $tyre->getAddress();
        $dto->deliveryCity    = $tyre->getDeliveryCity();
        $dto->deliveryCompany = $tyre->getDeliveryCompany();
        $dto->deliveryPost    = $tyre->getDeliveryPost();
        $dto->deliveryPayment = $tyre->getDeliveryPayment();
        $dto->price           = $tyre->getPrice();
        $dto->condition       = $tyre->getCondition();
        $dto->image           = $tyre->getImages();

        return $dto;
    }
}