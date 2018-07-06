<?php

namespace App\Service\Tyres;

use App\Entity\Tyres\Manufacturer;
use App\Entity\Tyres\Picture;
use App\Entity\Tyres\Seasonality;
use App\Entity\Tyres\Thorn;
use App\Entity\Tyres\Tyre;
use App\Entity\Tyres\Vendor;
use League\Csv\Reader;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TyresService
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function parse()
    {
        set_time_limit(300);

//        $file = 'test.csv';
//        $file = '795.csv';
        $file = '615.csv';
//        $file = '616.csv';

        $path = $this->container->get('kernel')->getProjectDir() . '/public/' . $file;
        $em   = $this->container->get('doctrine.orm.default_entity_manager');
        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        $reader = Reader::createFromPath($path);
        $reader->setDelimiter(';');
        $reader->setHeaderOffset(0);
        $header = [
            'header', 'tire_type', 'year', 'manufacturer', 'model', 'profile_width_mm',
            'profile_height_proc', 'wheel_width_inc', 'wheel_height_inc', 'landing_diameter_mm',
            'landing_diameter_inc', 'commercial', 'seasonality', 'status',
            'quantity', 'thorns', 'ply_rating', 'index_of_speed', 'load_index',
            'mud_at', 'dirt_mt', 'axis', 'presence_of_camera', 'radius', 'moto_class',
            'in_order', 'tra_code', 'lt_tire_function', 'price', 'availability',
            'description', 'pictures', 'opt', 'region', 'city', 'link_youtube'
        ];
        $records = $reader->getRecords($header);
        $i = 0;
        $batchSize = 25;
        $nameVendor = 'ALFACAR';

        foreach ($records as $offset => $record) {
//            dump($record);
//            $q = $this->em->createQuery('update MyProject\Model\Manager m set m.salary = m.salary * 0.9');
//            $numUpdated = $q->execute();

            $vendor = $em->getRepository(Vendor::class)->findOneBy([
                'name' => mb_convert_encoding($nameVendor, 'UTF-8', 'Windows-1251')
            ]);

            $manufacturer = $em->getRepository(Manufacturer::class)->findOneBy([
                'name' => mb_convert_encoding($record['manufacturer'], 'UTF-8', 'Windows-1251')
            ]);

            $seasonality = $em->getRepository(Seasonality::class)->findOneBy([
                'name' => mb_convert_encoding($record['seasonality'], 'UTF-8', 'Windows-1251')
            ]);

            $thorn = $em->getRepository(Thorn::class)->findOneBy([
                'name' => mb_convert_encoding($record['thorns'], 'UTF-8', 'Windows-1251')
            ]);

            $tyre = new Tyre();
            $tyre->setDiameter((int) $record['landing_diameter_mm']);
            $tyre->setHeight((int) $record['profile_height_proc']);
            $tyre->setWidth((int) $record['profile_width_mm']);
            $tyre->setCount((int) $record['quantity']);
            $tyre->setStatus(0);
            $tyre->setAvailability(0);
            $tyre->addVendors($vendor);
            $tyre->setManufacturers($manufacturer);
            $tyre->setSeasonalitys($seasonality);
            $tyre->setThorns($thorn);
            $em->persist($tyre);

            $pictures = explode(',', $record['pictures']);

            foreach ($pictures as $item) {
                $picture = new Picture();
                $picture->setPath(mb_convert_encoding($item, 'UTF-8', 'Windows-1251'));
                $picture->setTyres($tyre);
                $em->persist($picture);
            }

            if (($i % $batchSize) === 0) {
                $em->flush();
                $em->clear();
            }
            $i++;
        }

        $em->flush();
        $em->clear();
    }
}