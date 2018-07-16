<?php

namespace App\Command;

use App\Entity\Parts\Brand;
use App\Entity\Parts\Carcase;
use App\Entity\Parts\Engine;
use App\Entity\Parts\Model;
use App\Entity\Parts\Oem;
use App\Entity\Parts\Part;
use App\Entity\Parts\Vendor;
use App\Entity\Region\City;
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
        $file = 'big_parts.csv';



        $path = $this->container->get('kernel')->getProjectDir() . '/public/' . DIRECTORY_SEPARATOR . $file;
        $em = $this->container->get('doctrine.orm.default_entity_manager');

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
            $hash = md5(
                $record['brand'] .
                $record['model']
            );

            $record = $this->valid($record, $em, $nameVendor);
//            $oem    = $em->getRepository(Oem::class)->findOneBy(['hash' => $hash]);

           // if ($oem === null) {
                $oem = new Oem();
                $this->oem($oem, $record, $hash);
                $em->persist($oem);

//                $picture = new Picture();
//                $this->json($tyre, $picture, $record['pictures'], $serializer);
//                $em->persist($picture);
//            } else {
//                $this->tyre($tyre, $record, $hash);
//                $em->merge($tyre);
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
        $record['vendor'] = $em->getRepository(Vendor::class)->findOneBy([
            'name' => mb_convert_encoding($nameVendor, 'UTF-8', 'Windows-1251')
        ]);

        $record['model'] = $em->getRepository(Model::class)->findOneBy([
            'name' => mb_convert_encoding($record['model'], 'UTF-8', 'Windows-1251')
        ]);

        $record['brand'] = $em->getRepository(Brand::class)->findOneBy([
            'name' => mb_convert_encoding($record['brand'], 'UTF-8', 'Windows-1251')
        ]);

        $record['carcase'] = $em->getRepository(Carcase::class)->findOneBy([
            'name' => mb_convert_encoding($record['carcase'], 'UTF-8', 'Windows-1251')
        ]);

        $record['city'] = $em->getRepository(City::class)->findOneBy([
            'name' => mb_convert_encoding($record['city'], 'UTF-8', 'Windows-1251')
        ]);

        $record['engine'] = $em->getRepository(Engine::class)->findOneBy([
            'name' => mb_convert_encoding($record['engine'], 'UTF-8', 'Windows-1251')
        ]);

        $record['part'] = $em->getRepository(Part::class)->findOneBy([
            'name' => mb_convert_encoding($record['part'], 'UTF-8', 'Windows-1251')
        ]);

        return $record;
    }

    /**
     * @param Oem $oem
     * @param $record
     * @param $hash
     */
    private function oem($oem, array $record, $hash)
    {
        $oem->setHash($hash);
        $oem->setPart($record['part']);
        $oem->setBrand($record['brand']);
        $oem->setModel($record['model']);
        $oem->setCarcase($record['carcase']);
        $oem->setCity($record['city']);
        $oem->setEngine($record['engine']);
        $oem->setVendor($record['vendor']);
        $oem->setName( mb_convert_encoding($record['oem'], 'UTF-8', 'Windows-1251'));
    }
}