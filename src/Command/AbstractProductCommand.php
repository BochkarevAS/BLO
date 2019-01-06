<?php

namespace App\Command;

use App\Entity\ProductInterface;

abstract class AbstractProductCommand extends AbstractExecuteCommand
{
    abstract protected function assemble(ProductInterface $product, array $record, $hash, $dto, $user);

    abstract protected function hash(array $record);

    /**
     * Добовляет новые картинки при добавлении нового объявления в БД.
     * Так происходит потомучто картинку нужно в начале скачать а потом применить MD5.
     */
    protected function insertImage(ProductInterface $entity, $record)
    {
        $record['image'] = mb_convert_encoding(strtolower($record['image']), 'UTF-8', 'Windows-1251');

        $links = preg_split("/[,;\s]+/", $record['image']);

        $entity->setLinks($links);
        $entity->setImages([]);
    }
}