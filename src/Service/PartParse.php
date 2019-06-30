<?php

declare(strict_types=1);

namespace App\Service\Parse;

use App\Entity\Client\Company;
use App\Entity\Client\Price;
use App\Entity\Parts\Brand;
use App\Entity\Parts\Engine;
use App\Entity\Parts\Frame;
use App\Entity\Parts\Model;
use App\Entity\Parts\Part;
use App\Entity\Region\City;
use App\Service\Util\Progress;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * У нас подобные скрипты работают в фоновом режими (очереди)
 * Что бы небыло утечки памяти желательно скрипт обернуть в Supervisor
 * Или если нужно симитировать многопоточность ...
 */
class PartParse implements ParseInterface
{
    const HEADLINE = [
        'name', 'brand', 'models', 'frames', 'engines', 'oem', 'marking','UD', 'FR', 'RL',
        'declaration', 'condition', 'availability', 'price', 'code', 'image'
    ];

    protected $em;

    protected $pathCsv;

    protected $progress;

    public function __construct(EntityManagerInterface $em, $pathCsv, Progress $progress)
    {
        $this->em       = $em;
        $this->pathCsv  = $pathCsv;
        $this->progress = $progress;
    }

    protected function initBrand()
    {
        $brands    = [];
        $templates = $this->em->getRepository(Brand::class)->findAll();

        /** @var Brand $brand */
        foreach ($templates as $brand) {
            $name = mb_strtolower($brand->getName());
            $brands[$name] = $brand;
        }

        return $brands;
    }

    protected function initModel()
    {
        $models    = [];
        $templates = $this->em->getRepository(Model::class)->findAll();

        /** @var Model $model */
        foreach ($templates as $model) {
            $name = mb_strtolower($model->getName());
            $models[$name] = $model;
        }

        return $models;
    }

    protected function initFrame()
    {
        $frames    = [];
        $templates = $this->em->getRepository(Frame::class)->findAll();

        /** @var Frame $frame */
        foreach ($templates as $frame) {
            $name = mb_strtolower($frame->getName());
            $frames[$name] = $frame;
        }

        return $frames;
    }

    protected function initEngine()
    {
        $engines   = [];
        $templates = $this->em->getRepository(Engine::class)->findAll();

        /** @var Engine $engine */
        foreach ($templates as $engine) {
            $name = mb_strtolower($engine->getName());
            $engines[$name] = $engine;
        }

        return $engines;
    }

    public function run(string $filename, int $price, int $company, int $city, string $type)
    {
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);

        $path = $this->pathCsv . DIRECTORY_SEPARATOR . $filename;

        $reader = Reader::createFromPath($path);
        $reader->setDelimiter(';');
        $reader->setHeaderOffset(0);

        $records = $reader->getRecords(self::HEADLINE);

        $i = 0;

        $brands  = $this->initBrand();
        $models  = $this->initModel();
        $frames  = $this->initFrame();
        $engines = $this->initEngine();

        $price   = $this->em->getRepository(Price::class)->find($price);
        $city    = $this->em->getRepository(City::class)->find($city);
        $company = $this->em->getRepository(Company::class)->find($company);

        /** @var ProgressBar $progress */
        $progress = $this->progress->run(count($reader));

        if (null === $progress) {
            return;
        }

        foreach ($records as $record) {
            $record['company_id'] = $company->getId();

            $hash = $this->hash($record);

            echo memory_get_usage() . "\n";

            /**
             * Тут очень уское место на миллионе записей доктрина постоянно будет искать хэши в БД
             * Нужно закинуть в КЭШ !!!
             *
             * @var Part $part
             */
            $part = $this->em->getRepository(Part::class)->findHash($hash);

            echo memory_get_usage() . "\n";

            if (null === $part) {
                $part = new Part();
                $this->assemble($part, $record, $hash, $city, $company, $brands, $models, $frames, $engines, $price);
                $this->insertImage($part, $record);
                $this->em->persist($part);
            } else {
                $this->assemble($part, $record, $hash, $city, $company, $brands, $models, $frames, $engines, $price);
                $this->em->merge($part);
            }

            if (0 === ($i % self::BATCH_SIZE)) {
                $this->em->flush();
                $this->em->clear(Part::class);

                /**
                 * На всякий случай вдруг PHP выбрал бы не запускать сборку мусора.
                 */
                gc_collect_cycles();

                $progress->setMessage("*Imported...*", 'status');
                $progress->advance(self::BATCH_SIZE);
            }

            $i++;
        }

        $this->em->flush();
        $this->em->clear();
        $progress->finish();
    }

    protected function insertImage(Part $entity, $record)
    {
        $links = [];

        if (!empty($record['image'])) {
            $links = preg_split("/[,;\s]+/", $record['image']);
        }

        $entity->setLinks($links);
        $entity->setImages([]);
    }

    public function assemble(Part $part, $record, $hash, $city, $company, array $brands, array $models, array $frames = null, array $engines = null, $price = null)
    {
        $patterns = null;
        $part->setClientPrice($price);
        $part->setName($record['name']);
        $part->setOem($record['oem']);
        $part->setMarking($record['marking']);
        $part->setDeclaration($record['declaration']);
        $part->setPrice($record['price']);
        $part->setHash($hash);

        if (isset($record['brand'])) {
            $brand = mb_strtolower($record['brand']);

            if (array_key_exists($brand, $brands)) {
                $brand = $brands[$brand];
                $part->setBrand($brand);
                /**
                 * Помечаем его для garbage-collectable.
                 * Таким образом PHP может удалить $brand из памяти.
                 */
                $brand = null;
                unset($brand);
            }
        }

        if (isset($record['models'])) {
            $patterns = array_map('strtolower', explode(',', $record['models']));

            foreach ($patterns as $model) {
                if (array_key_exists($model, $models)) {
                    $model = $models[$model];
                    $part->addModel($model);
                    $model = null;
                    unset($model);
                }
            }
        }

        if (isset($record['frames'])) {
            $patterns = array_map('strtolower', explode(',', $record['frames']));

            foreach ($patterns as $frame) {
                if (array_key_exists($frame, $frames)) {
                    $frame = $frames[$frame];
                    $part->addFrame($frame);
                    $frame = null;
                    unset($frame);
                }
            }
        }

        if (isset($record['engines'])) {
            $patterns = array_map('strtolower', explode(',', $record['engines']));

            foreach ($patterns as $engine) {
                if (array_key_exists($engine, $engines)) {
                    $engine = $engines[$engine];
                    $part->addEngine($engine);
                    $engine = null;
                    unset($engine);
                }
            }
        }

        if ($record['code']) {
            $part->setCode($record['code']);
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
    }

    public function hash(array $record)
    {
        return md5(
            $record['name'] .
            $record['brand'] .
            $record['models'] .
            $record['frames'] .
            $record['engines'] .
            $record['oem'] .
            $record['marking'] .
            $record['UD'] .
            $record['FR'] .
            $record['RL'] .
            $record['declaration'] .
            $record['condition'] .
            $record['availability'] .
            $record['code'] .
            $record['image'] .
            $record['company_id']
        );
    }
}