<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\TwigFilter;

class JsonDecode extends \Twig_Extension
{
    public function getName()
    {
        return 'twig.json_decode';
    }

    public function getFilters()
    {
        return [
            new TwigFilter('json_decode', [$this, 'jsonDecode'])
        ];
    }

    public function jsonDecode($str)
    {
        return json_decode($str, true);
    }
}