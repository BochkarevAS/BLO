<?php

namespace App\Command;

use App\Entity\Parts\Brand;
use App\Entity\Parts\Carcase;
use App\Entity\Parts\Engine;
use App\Entity\Parts\Model;
use App\Entity\Parts\Part;
use Doctrine\ORM\EntityManager;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class PartsCommand extends Command
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();

        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setName('import:parts')
            ->setDescription('Import parts from CSV file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new \DateTime();
        $output->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

        $this->import($input, $output);

        $now = new \DateTime();
        $output->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
    }

    protected function import(InputInterface $input, OutputInterface $output)
    {
//        $file = 'parts_test.csv';
//        $file = 'parts_new.csv';
        $file = 'big_parts.csv';
//        $file = 'parts_1.csv';

        $path = $this->container->get('kernel')->getProjectDir() . '/public/' . DIRECTORY_SEPARATOR . $file;
        $em   = $this->container->get('doctrine.orm.default_entity_manager');

        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        $stopwatch = new Stopwatch();
        $stopwatch->start('sanitize');

        $reader = Reader::createFromPath($path);
        $reader->setDelimiter(';');
        $reader->setHeaderOffset(0);
        $header = [
            'part', 'brand', 'model', 'availability', 'carcase', 'engine', 'number', 'oem',
            'year', 'colour', 'horizontally', 'vertically', 'order', 'price', 'type', 'tuning',
            'proporty', 'photo', 'opt', 'vendor', 'condition', 'region', 'city', 'youtube'
        ];
        $records = $reader->getRecords($header);

        $i = 0;
        $batchSize = 1000;
        $nameVendor = 'ALFACAR';

        $progress = new ProgressBar($output, count($reader));
        $progress->start();

        foreach ($records as $offset => $record) {
            $hash = md5($record['price'] . $record['brand'] . $record['model'] . $record['carcase'] . $record['engine']);

            $part = $em->getRepository(Part::class)->findOneBy(['hash' => $hash]);

            if ($part === null) {
                $part = new Part();
                $this->validation($part, $hash, $record, $em, $nameVendor);

//                $picture = new Picture();
//                $this->json($tyre, $picture, $record['pictures'], $serializer);
//                $em->persist($picture);
            } else {
                $this->validation($part, $hash, $record, $em, $nameVendor);
                $em->merge($part);

//                $picture = $em->getRepository(Picture::class)->find($tyre->getId());
//
//                if (!$picture) {
//                    $this->json($tyre, $picture, $record['pictures'], $serializer);
//                    $em->merge($picture);
//                }
            }

            if (($i % $batchSize) === 0) {
                $em->flush();
                $em->clear();

                $event = $stopwatch->lap('sanitize');
                $progress->advance($batchSize);
                $now = new \DateTime();
                $output->writeln(' of parts imported ... | ' . $now->format('d-m-Y G:i:s') . ' | memory used : ' . number_format($event->getMemory() / 1048576, 2) . ' MB');
            }

            $i++;
        }

        $em->flush();
        $em->clear();

        $progress->finish();
    }

    /**
     * @param Part $part
     * @param $hash
     * @param array $record
     * @param $em
     * @param $nameVendor
     */
    private function validation(Part $part, $hash, array $record, EntityManager $em, $nameVendor)
    {
        $part->setName(mb_convert_encoding($record['part'], 'UTF-8', 'Windows-1251'));
        $part->setHash($hash);
        $part->setPrice((int) $record['price']);

        if ($record['brand']) {
            $brand = $em->getRepository(Brand::class)->findByName(mb_convert_encoding($record['brand'], 'UTF-8', 'Windows-1251'));
            $part->setBrand($brand);
        }

        $patterns = array_map('strtoupper', preg_split("/[\s,#\/]+/", $record['model']));

        if ($patterns) {
            $models = $em->getRepository(Model::class)->findAllByNames(mb_convert_encoding($patterns, 'UTF-8', 'Windows-1251'));
            foreach ($models as $model) {
                $part->addModel($model);
            }
        }

        $patterns = array_map('strtoupper', preg_split("/[\s,#\/]+/", $record['carcase']));

        if ($patterns) {
            $carcases = $em->getRepository(Carcase::class)->findAllByNames(mb_convert_encoding($patterns, 'UTF-8', 'Windows-1251'));
            foreach ($carcases as $carcase) {
                $part->addCarcase($carcase);
            }
        }

        $patterns = array_map('strtoupper', preg_split("/[\s,#\/]+/", $record['engine']));

        if ($patterns) {
            $engines = $em->getRepository(Engine::class)->findAllByNames(mb_convert_encoding($patterns, 'UTF-8', 'Windows-1251'));
            foreach ($engines as $engine) {
                $part->addEngine($engine);
            }
        }

        $em->persist($part);
    }
}