<?php

namespace App\Command;

use App\Entity\Client\Company;
use App\Entity\Region\City;
use App\Entity\Tyres\Brand;
use App\Entity\Tyres\Model;
use App\Entity\Tyres\Seasonality;
use App\Entity\Tyres\Thorn;
use App\Entity\Tyres\Tyre;
use Doctrine\ORM\EntityManager;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class TyresCommand extends Command
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
            ->setName('import:tyres')
            ->setDescription('Import tyres from CSV file')
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
        $file = '616.csv';
//        $file = 'test.csv';

        $path = $this->container->get('kernel')->getProjectDir() . '/public/' . DIRECTORY_SEPARATOR . $file;
        $em   = $this->container->get('doctrine.orm.default_entity_manager');

        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        $stopwatch = new Stopwatch();
        $stopwatch->start('sanitize');

        $reader = Reader::createFromPath($path);
        $reader->setDelimiter(';');
        $reader->setHeaderOffset(0);
        $header = [
            'header', 'tire_type', 'year', 'brand', 'model', 'width_mm',
            'height_proc', 'wheel_width_inc', 'wheel_height_inc', 'diameter_mm',
            'landing_diameter_inc', 'commercial', 'seasonality', 'status',
            'quantity', 'thorn', 'ply_rating', 'index_of_speed', 'load_index',
            'mud_at', 'dirt_mt', 'axis', 'presence_of_camera', 'radius', 'moto_class',
            'in_order', 'tra_code', 'lt_tire_function', 'price', 'availability',
            'description', 'pictures', 'opt', 'region', 'city', 'link_youtube'
        ];
        $records = $reader->getRecords($header);

        $i = 0;
        $batchSize = 1000;
        $company = 'Vladmotors';

        $progress = new ProgressBar($output, count($reader));
        $progress->start();

        foreach ($records as $offset => $record) {
            $hash = md5($record['diameter_mm'] . $record['height_proc'] . $record['width_mm'] . $record['model'] . $record['index_of_speed'] . $record['load_index'] . $record['brand']);

            $tyre = $em->getRepository(Tyre::class)->findOneBy(['hash' => $hash]);

            if ($tyre === null) {
                $tyre = new Tyre();
                $this->insert($tyre, $hash, $record, $em, $company);
                $json = $this->json($tyre->getId(), $record['photo']);
                $tyre->setPicture($json);

                $em->persist($tyre);
            } else {
                $this->insert($tyre, $hash, $record, $em, $company);
                $json = $this->json($tyre->getId(), $record['photo']);
                $tyre->setPicture($json);

                $em->merge($tyre);
            }

            if (($i % $batchSize) === 0) {
                $em->flush();
                $em->clear();

                $event = $stopwatch->lap('sanitize');
                $progress->advance($batchSize);
                $now = new \DateTime();
                $output->writeln(' of tyres imported ... | ' . $now->format('d-m-Y G:i:s') . ' | memory used : ' . number_format($event->getMemory() / 1048576, 2) . ' MB');
            }

            $i++;
        }

        $em->flush();
        $em->clear();

        $stopwatch->stop('sanitize');
        $progress->finish();
    }

    private function insert(Tyre $tyre, $hash, array $record, EntityManager $em, $company)
    {
        $tyre->setName(mb_convert_encoding($record['part'], 'UTF-8', 'Windows-1251'));
        $tyre->setHash($hash);
        $tyre->setPrice((int) $record['price']);

        if ($record['brand']) {
            $brand = $em->getRepository(Brand::class)->findByName(mb_convert_encoding($record['brand'], 'UTF-8', 'Windows-1251'));
            $tyre->setBrand($brand);
        }

        $patterns = array_map('strtoupper', preg_split("/[\s,#\/]+/", $record['model']));

        if ($patterns) {
            $models = $em->getRepository(Model::class)->findAllByNames(mb_convert_encoding($patterns, 'UTF-8', 'Windows-1251'));
            foreach ($models as $model) {
                $tyre->addModel($model);
            }
        }

        $city = $em->getRepository(City::class)->findByName(mb_convert_encoding($record['city'], 'UTF-8', 'Windows-1251'));

        if ($city) {
            $tyre->setCity($city);
        }

        $company = $em->getRepository(Company::class)->findByName($company);

        if ($company) {
            $tyre->setCompany($company);
        }

//        $record['seasonality'] = $em->getRepository(Seasonality::class)->findOneBy([
//            'name' => mb_convert_encoding($record['seasonality'], 'UTF-8', 'Windows-1251')
//        ]);
//
//        $record['thorn'] = $em->getRepository(Thorn::class)->findOneBy([
//            'name' => mb_convert_encoding($record['thorn'], 'UTF-8', 'Windows-1251')
//        ]);

        $em->persist($tyre);
    }

    private function json($id, $link)
    {
        $serializer = $this->container->get('serializer');

        $json = [
            'id'    => $id,
            'links' => mb_convert_encoding($link, 'UTF-8', 'Windows-1251')
        ];

        return $serializer->serialize($json, 'json');
    }
}