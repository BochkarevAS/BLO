<?php

declare(strict_types=1);

namespace App\Request;

use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class DataTransferObjectConverter implements ParamConverterInterface
{
    private $serializer;

    private $denormalizer;

    public function __construct(SerializerInterface $serializer, DenormalizerInterface $denormalizer)
    {
        $this->serializer   = $serializer;
        $this->denormalizer = $denormalizer;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $data  = $request->request->all();
        $class = $configuration->getClass();

        $dto = $this->serializer->deserialize($data, $class, 'json');

        if (0 < $request->files->count()) {
            $dto->images = $request->files->all();
        }

        $request->attributes->set($configuration->getName(), $dto);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        return "dto" === $configuration->getName();
    }
}