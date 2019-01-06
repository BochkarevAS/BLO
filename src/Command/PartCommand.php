<?php

namespace App\Command;

use App\Dto\PartDto;
use App\Entity\Auth\User;
use App\Entity\Client\Company;
use App\Entity\Parts\Brand;
use App\Entity\Parts\Frame;
use App\Entity\Parts\Engine;
use App\Entity\Parts\Model;
use App\Entity\Parts\Part;
use App\Entity\ProductInterface;
use App\Entity\Region\City;
use League\Csv\Reader;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PartCommand extends AbstractProductCommand
{
    const HEADER = [
        'name', 'brand', 'models', 'frames', 'engines', 'oem', 'marking','UD', 'FR', 'RL',
        'declaration', 'condition', 'availability', 'price', 'image'
    ];

    protected function configure()
    {
        $this
            ->setName('import:part')
            ->setDescription('Import part from CSV file')
        ;
    }

    protected function import(InputInterface $input, OutputInterface $output)
    {
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);

        $file = 'example.csv';
        $file = 'example1.csv';
//        $file = 'test3.csv';

        $path = $this->params->get('prices_part') . DIRECTORY_SEPARATOR . $file;

        $reader = Reader::createFromPath($path);
        $reader->setDelimiter(';');
        $reader->setHeaderOffset(0);

        $records = $reader->getRecords(self::HEADER);

        $dto = new PartDto();

        /** @var ProgressBar $progress */
        $progress = $this->runProgressBar($output, (int) count($reader));

        $i = 0;

        $brands  = [];
        $models  = [];
        $frames  = [];
        $engines = [];

        $allBrands = $this->em->getRepository(Brand::class)->findAll();
        foreach ($allBrands as $brand) {
            /** @var Brand $brand */
            $name = mb_strtolower($brand->getName());
            $brands[$name] = $brand;
        }

        $allModels = $this->em->getRepository(Model::class)->findAll();
        foreach ($allModels as $model) {
            /** @var Model $model */
            $name = mb_strtolower($model->getName());
            $models[$name] = $model;
        }

        $allFrames = $this->em->getRepository(Frame::class)->findAll();
        foreach ($allFrames as $frame) {
            /** @var Frame $frame */
            $name = mb_strtolower($frame->getName());
            $frames[$name] = $frame;
        }

        $allEngines = $this->em->getRepository(Engine::class)->findAll();
        foreach ($allEngines as $engine) {
            /** @var Engine $engine */
            $name = mb_strtolower($engine->getName());
            $engines[$name] = $engine;
        }

        $dto->brands  = $brands;
        $dto->models  = $models;
        $dto->frames  = $frames;
        $dto->engines = $engines;

        $dto->city    = $this->em->getRepository(City::class)->find(1);
        $dto->company = $this->em->getRepository(Company::class)->find(1);

        $user = $this->em->getRepository(User::class)->find(1);

        foreach ($records as $record) {
            $hash = $this->hash($record);

            /** @var Part $part */
            $part = $this->em->getRepository(Part::class)->findOneBy(['hash' => $hash]);

            if (!$part) {
                /** Получем текущие заплонированные вставки объекта */
                $insertions = $this->em->getUnitOfWork()->getScheduledEntityInsertions();
                foreach ($insertions as $insertion) {
                    /** @var Part $insertion */
                    if ($insertion instanceof Part && $hash === $insertion->getHash()) {
                        $part = $insertion;
                        break;
                    }
                }
            }

            if (null === $part) {
                $part = new Part();
                $this->assemble($part, $record, $hash, $dto, $user);
                $this->insertImage($part, $record);
                $this->em->persist($part);
            } else {
                $this->assemble($part, $record, $hash, $dto, $user);
                $this->em->merge($part);
            }

            if (0 === ($i % self::BATCH_SIZE)) {
                $this->em->flush();
                $this->em->clear(Part::class);

                $progress->setMessage($i, 'item');
                $progress->advance(self::BATCH_SIZE);
            }

            $i++;
        }

        $this->em->flush();
        $this->em->clear();

        $progress->finish();
    }

    protected function hash(array $record)
    {
        return md5(
            $record['name'] .
            $record['brand'] .
            $record['models'] .
            $record['frames'] .
            $record['engines'] .
            $record['oem'] .
            $record['marking'] .
            $record['image'] .
            $record['availability'] .
            $record['condition'] .
            $record['UD'] .
            $record['FR'] .
            $record['RL']
        );
    }

    /**
     * @var Part $part
     */
    protected function assemble(ProductInterface $part, array $record, $hash, $dto, $user)
    {
        $part->setName($record['name']);
        $part->setOem($record['oem']);
        $part->setMarking($record['marking']);
        $part->setHash($hash);

        $brands  = $dto->brands;
        $models  = $dto->models;
        $frames  = $dto->frames;
        $engines = $dto->engines;
        $city    = $dto->city;
        $company = $dto->company;

        $brand = mb_strtolower($record['brand']);
        if (array_key_exists($brand, $brands)) {
            $brand = $brands[$brand];
            $part->setBrand($brand);
        }

        $patterns = array_map('strtolower', explode(',', $record['models']));
        foreach ($patterns as $model) {
            if (array_key_exists($model, $models)) {
                $model = $models[$model];
                $part->addModel($model);
            }
        }

        $patterns = array_map('strtolower', explode(',', $record['frames']));
        foreach ($patterns as $frame) {
            if (array_key_exists($frame, $frames)) {
                $frame = $frames[$frame];
                $part->addFrame($frame);
            }
        }

        $patterns = array_map('strtolower', explode(',', $record['engines']));
        foreach ($patterns as $engine) {
            if (array_key_exists($engine, $engines)) {
                $engine = $engines[$engine];
                $part->addEngine($engine);
            }
        }

        if ($record['price']) {
            $part->setPrice($record['price']);
        }

        if ($record['UD']) {
            $part->setUd($record['UD']);
        }

        if ($record['FR']) {
            $part->setFr($record['FR']);
        }

        if ($record['RL']) {
            $part->setRl($record['RL']);
        }

        if ($record['availability']) {
            $part->setAvailability($record['availability']);
        }

        if ($record['condition']) {
            $part->setCondition($record['condition']);
        }

        if ($city) {
            $part->setCity($city);
        }

        if ($company) {
            $part->setCompany($company);
        }

        if ($user) {
            $part->setUser($user);
        }
    }
}