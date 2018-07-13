<?php

namespace App\Command;

use App\Entity\Parts\Oem;
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
        $path = $this->container->get('kernel')->getProjectDir() . '/public/' . DIRECTORY_SEPARATOR . $file;
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        $stopwatch = new Stopwatch();
        $stopwatch->start('sanitize');

        $reader = Reader::createFromPath($path);
        $reader->setDelimiter(';');
        $reader->setHeaderOffset(0);
        $header = [
            'headline', 'mark', 'model', 'availability', 'body', 'engine', 'number', 'oem',
            'year', 'colour', 'horizontally', 'vertically', 'order', 'price', 'type', 'tuning',
            'proporty', 'photo', 'opt', 'manufacturer', 'condition', 'region', 'city', 'youtube'
        ];
        $records = $reader->getRecords($header);

        $i = 0;
        $batchSize = 1000;
        $nameVendor = 'ALFACAR';

        $progress = new ProgressBar($output, count($reader));
        $progress->start();

        foreach ($records as $offset => $record) {
            $hash = md5(
                $record['mark'] .
                $record['model']
            );

            $oem = new Oem();
            $this->oem($oem, $record, $hash);
            $em->persist($oem);

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


        return $record;
    }

    /**
     * @param Oem $oem
     * @param $record
     * @param $hash
     */
    private function oem($oem, array $record, $hash)
    {
        $oem->setParts($record['headline']);
        $oem->setBrands($record['mark']);
        $oem->setModels($record['model']);
        $oem->setVendors($record['manufacturer']);
    }
}