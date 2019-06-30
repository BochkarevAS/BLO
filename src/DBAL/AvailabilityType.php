<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class AvailabilityType extends AbstractEnumType
{
    const STOCK      = 'stock';
    const COMMISSION = 'commission';

    public static $availability = [
        1 => self::STOCK,
        2 => self::COMMISSION
    ];

    protected static $choices = [
        self::STOCK      => 'в наличии',
        self::COMMISSION => 'под заказ'
    ];
}