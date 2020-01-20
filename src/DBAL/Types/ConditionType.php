<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class ConditionType extends AbstractEnumType
{
    const NEW  = 'new';
    const USED = 'used';

    public static $condition = [
        1 => self::NEW,
        2 => self::USED
    ];

    protected static $choices = [
        self::NEW  => 'новый',
        self::USED => 'контрак/бу'
    ];
}