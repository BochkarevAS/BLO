<?php

namespace App\Command;

use App\Entity\Client\Company;
use App\Entity\Parts\Brand;
use App\Entity\Parts\Carcase;
use App\Entity\Parts\Engine;
use App\Entity\Parts\Marking;
use App\Entity\Parts\Model;
use App\Entity\Parts\Oem;
use App\Entity\Parts\Part;
use App\Entity\Region\City;
use Doctrine\ORM\EntityManager;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class PartCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('import:part')
            ->setDescription('Import part from CSV file')
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
//        $file = 'parts_1.csv';
        $file = 'big_parts.csv';

        $path = $this->getContainer()->get('kernel')->getProjectDir() . '/public/uploads/' . DIRECTORY_SEPARATOR . $file;
        $em   = $this->getContainer()->get('doctrine')->getManager();

        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        $stopwatch = new Stopwatch();
        $stopwatch->start('sanitize');

        $reader = Reader::createFromPath($path);
        $reader->setDelimiter(';');
        $reader->setHeaderOffset(0);
        $header = [
            'part', 'brand', 'model', 'availability', 'carcase', 'engine', 'number_mark', 'oem',
            'year', 'colour', 'horizontally', 'vertically', 'order', 'price', 'type', 'tuning',
            'proporty', 'image', 'opt', 'vendor', 'condition', 'region', 'city', 'youtube'
        ];
        $records = $reader->getRecords($header);

        $i = 0;
        $batchSize = 1000;
        $company = 'Vladmotors';

        $progress = new ProgressBar($output, count($reader));
        $progress->start();

        foreach ($records as $offset => $record) {
            $hash = md5(
                $record['part'] .
                $record['brand'] .
                $record['model'] .
                $record['carcase'] .
                $record['engine'] .
                $record['oem'] .
                $record['city'] .
                $record['image'] .
                $record['availability'] .
                $record['condition'] .
                $record['number_mark']
            );

            $part = $em->getRepository(Part::class)->findOneBy(['hash' => $hash]);

            if ($part === null) {
                $part = new Part();
                $this->insert($part, $hash, $record, $em, $company);
                $em->persist($part);
            } else {
                $this->insert($part, $hash, $record, $em, $company);
                $em->merge($part);
            }

            if (($i % $batchSize) === 0) {
                $em->flush();
                $em->clear();

                $event = $stopwatch->lap('sanitize');
                $progress->advance($batchSize);
                $now = new \DateTime();
                $output->writeln(' of part imported ... | ' . $now->format('d-m-Y G:i:s') . ' | memory used : ' . number_format($event->getMemory() / 1048576, 2) . ' MB');
            }

            $i++;
        }

        $em->flush();
        $em->clear();

        $progress->finish();
    }

    private function insert(Part $part, $hash, array $record, EntityManager $em, $company)
    {
        $part->setName(mb_convert_encoding($record['part'], 'UTF-8', 'Windows-1251'));
        $part->setHash($hash);
        $part->setPrice((int) $record['price']);

        if ($record['brand']) {
            $brand = $em->getRepository(Brand::class)->findByName(mb_convert_encoding($record['brand'], 'UTF-8', 'Windows-1251'));
            $part->setBrand($brand);
        }

        if ($record['model']) {
            $model = $em->getRepository(Model::class)->findByName(mb_convert_encoding($record['model'], 'UTF-8', 'Windows-1251'));
            $part->setModel($model);
        }

        if ($record['carcase']) {
            $carcase = $em->getRepository(Carcase::class)->findByName(mb_convert_encoding($record['carcase'], 'UTF-8', 'Windows-1251'));
            $part->setCarcase($carcase);
        }

//        if ($record['number_mark']) {
//            $mark = $em->getRepository(Marking::class)->findByName(mb_convert_encoding($record['number_mark'], 'UTF-8', 'Windows-1251'));
//            $part->setMark($mark);
//        }

        $patterns = array_map('strtoupper', preg_split("/[\s,#\/]+/", $record['engine']));

        if ($patterns) {
            $engines = $em->getRepository(Engine::class)->findAllByNames(mb_convert_encoding($patterns, 'UTF-8', 'Windows-1251'));
            foreach ($engines as $engine) {
                $part->addEngine($engine);
            }
        }

        $patterns = array_map('strtoupper', preg_split("/[\s,#\/]+/", $record['oem']));

        if ($patterns) {
            $oems = $em->getRepository(Oem::class)->findAllByNames(mb_convert_encoding($patterns, 'UTF-8', 'Windows-1251'));
            foreach ($oems as $oem) {
                $part->addOem($oem);
            }
        }

        $city = $em->getRepository(City::class)->findByName(mb_convert_encoding($record['city'], 'UTF-8', 'Windows-1251'));

        if ($city) {
            $part->setCity($city);
        }

        $company = $em->getRepository(Company::class)->findByName($company);

        if ($company) {
            $part->setCompany($company);
        }

        $images = explode(',', $record['image']);
        $json = json_encode($images);
        $part->setImage($json);
    }
}