<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\ProductInterface;

abstract class AbstractProductCommand extends AbstractExecuteCommand
{
    abstract protected function assemble(ProductInterface $product, array $record, $hash, $dto, $user);

    abstract protected function hash(array $record);

    protected function insertImage(ProductInterface $entity, $record)
    {
        /**
         * Ну что за херня mb_convert_encoding костыл. Нужно сразу файлы кодировать нормально ...
         */
        $record['image'] = mb_convert_encoding(strtolower($record['image']), 'UTF-8', 'Windows-1251');

        $links = preg_split("/[,;\s]+/", $record['image']);

        $entity->setLinks($links);
        $entity->setImages([]);
    }
}