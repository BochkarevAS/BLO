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
        $file = 'parts_test.csv';
//        $file = 'big_parts.csv';
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


        $brands = $em->getRepository(Brand::class)->findAllByNames();


        foreach ($records as $offset => $record) {
            $hash = md5($record['brand'] . $record['model'] . $record['carcase'] . $record['engine']);

//            $record = $this->valid($record, $em, $nameVendor);
//            $part = $em->getRepository(Part::class)->findOneBy(['hash' => $hash]);

//            if ($part === null) {



            $part = new Part();
            $part->setName(mb_convert_encoding($record['part'], 'UTF-8', 'Windows-1251'));
            $part->setHash($hash);
            $part->setPrice((int) $record['price']);

            $patterns = preg_split("/[\s,#\/]+/", $record['brand']);

            dump($patterns);

            if ($patterns) {
                $brands = $em->getRepository(Brand::class)->findAllByNames($patterns);
                $part->addBrand($brands);
            }



//            foreach ($brands as $brand) {
//                $brand = $em->createQueryBuilder()
//                    ->select('b')
//                    ->from(Brand::class, 'b')
//                    ->where('upper(b.name) = upper(:name)')
//                    ->setParameter('name', mb_convert_encoding($brand, 'UTF-8', 'Windows-1251'))
//                    ->setMaxResults(1)
//                    ->getQuery()
//                    ->getOneOrNullResult();
//
//                if ($brand) {
//                    $part->addBrand($brand);
//                }
//            }

            $models = preg_split("/[\s,#\/]+/", $record['model']);
            foreach ($models as $model) {
                $model = $em->createQueryBuilder()
                    ->select('m')
                    ->from(Model::class, 'm')
                    ->where('upper(m.name) = upper(:name)')
                    ->setParameter('name', mb_convert_encoding($model, 'UTF-8', 'Windows-1251'))
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();

                if ($model) {
                    $part->addModel($model);
                }
            }

            $carcases = preg_split("/[\s,#\/]+/", $record['carcase']);
            foreach ($carcases as $carcase) {
                $carcase = $em->createQueryBuilder()
                    ->select('c')
                    ->from(Carcase::class, 'c')
                    ->where('upper(c.name) = upper(:name)')
                    ->setParameter('name', mb_convert_encoding($carcase, 'UTF-8', 'Windows-1251'))
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();

                if ($carcase) {
                    $part->addCarcase($carcase);
                }
            }

            $engines = preg_split("/[\s,#\/]+/", $record['engine']);
            foreach ($engines as $engine) {
                $engine = $em->createQueryBuilder()
                    ->select('e')
                    ->from(Engine::class, 'e')
                    ->where('upper(e.name) = upper(:name)')
                    ->setParameter('name', mb_convert_encoding($engine, 'UTF-8', 'Windows-1251'))
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();

                if ($engine) {
                    $part->addEngine($engine);
                }
            }

            $em->persist($part);





//                $this->part($part, $record, $hash);




//                $picture = new Picture();
//                $this->json($tyre, $picture, $record['pictures'], $serializer);
//                $em->persist($picture);
//            } else {
//                $this->part($part, $record, $hash);
//                $em->merge($part);
//                $picture = $em->getRepository(Picture::class)->find($tyre->getId());
//
//                if (!$picture) {
//                    $this->json($tyre, $picture, $record['pictures'], $serializer);
//                    $em->merge($picture);
//                }
//            }

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
     * @param array $record
     * @param EntityManager $em
     * @param $nameVendor
     * @return array
     */
    private function valid(array $record, $em, $nameVendor)
    {




//        $record['vendor'] = $em->createQueryBuilder()
//                                ->select('v')
//                                ->from(Vendor::class, 'v')
//                                ->where('upper(v.name) = upper(:name)')
//                                ->setParameter('name', mb_convert_encoding($record['vendor'], 'UTF-8', 'Windows-1251'))
//                                ->setMaxResults(1)
//                                ->getQuery()
//                                ->getOneOrNullResult();
//
//        $record['model'] = $em->createQueryBuilder()
//                                ->select('m')
//                                ->from(Model::class, 'm')
//                                ->where('upper(m.name) = upper(:name)')
//                                ->setParameter('name', mb_convert_encoding($record['model'], 'UTF-8', 'Windows-1251'))
//                                ->setMaxResults(1)
//                                ->getQuery()
//                                ->getOneOrNullResult();
//
//        $record['brand'] = $em->createQueryBuilder()
//                                ->select('b')
//                                ->from(Brand::class, 'b')
//                                ->where('upper(b.name) = upper(:name)')
//                                ->setParameter('name', mb_convert_encoding($record['brand'], 'UTF-8', 'Windows-1251'))
//                                ->setMaxResults(1)
//                                ->getQuery()
//                                ->getOneOrNullResult();
//
//        $record['carcase'] = $em->createQueryBuilder()
//                                ->select('c')
//                                ->from(Carcase::class, 'c')
//                                ->where('upper(c.name) = upper(:name)')
//                                ->setParameter('name', mb_convert_encoding($record['carcase'], 'UTF-8', 'Windows-1251'))
//                                ->setMaxResults(1)
//                                ->getQuery()
//                                ->getOneOrNullResult();
//
//        $record['part'] = $em->createQueryBuilder()
//                                ->select('p')
//                                ->from(PartName::class, 'p')
//                                ->where('upper(p.name) = upper(:name)')
//                                ->setParameter('name', mb_convert_encoding($record['part'], 'UTF-8', 'Windows-1251'))
//                                ->setMaxResults(1)
//                                ->getQuery()
//                                ->getOneOrNullResult();
//
//        $record['city'] = $em->createQueryBuilder()
//                                ->select('c')
//                                ->from(City::class, 'c')
//                                ->where('upper(c.name) = upper(:name)')
//                                ->setParameter('name', mb_convert_encoding($record['city'], 'UTF-8', 'Windows-1251'))
//                                ->setMaxResults(1)
//                                ->getQuery()
//                                ->getOneOrNullResult();
//
//        $record['engine'] = $em->createQueryBuilder()
//                                ->select('e')
//                                ->from(Engine::class, 'e')
//                                ->where('upper(e.name) = upper(:name)')
//                                ->setParameter('name', mb_convert_encoding($record['engine'], 'UTF-8', 'Windows-1251'))
//                                ->setMaxResults(1)
//                                ->getQuery()
//                                ->getOneOrNullResult();
//
//        $record['oem'] = $em->createQueryBuilder()
//                                ->select('o')
//                                ->from(Oem::class, 'o')
//                                ->where('upper(o.name) = upper(:name)')
//                                ->setParameter('name', mb_convert_encoding($record['oem'], 'UTF-8', 'Windows-1251'))
//                                ->setMaxResults(1)
//                                ->getQuery()
//                                ->getOneOrNullResult();

        return $record;
    }

    /**
     * @param Part $part
     * @param $record
     * @param $hash
     */
//    private function part($part, array $record, $hash)
//    {
//        $part->setHash($hash);
//        $part->setPart($record['part']);
//        $part->setBrand($record['brand']);
//        $part->setModel($record['model']);
//        $part->setCarcase($record['carcase']);
//        $part->setCity($record['city']);
//        $part->setEngine($record['engine']);
//        $part->setVendor($record['vendor']);
//        $part->setOem($record['oem']);
//        $part->setPrice($record['price']);
//    }
}