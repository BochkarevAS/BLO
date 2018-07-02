<?php

namespace App\Service\Tyres;

use App\Entity\Tyres\Manufacturer;
use App\Entity\Tyres\Seasonality;
use App\Entity\Tyres\Thorn;
use App\Entity\Tyres\Tyre;
use Doctrine\Common\Persistence\ObjectManager;
use League\Csv\Reader;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TyresService
{
    private $container;
    private $em;

    public function __construct(ContainerInterface $container, ObjectManager $em)
    {
        $this->container = $container;
        $this->em = $em;
    }

    public function parse()
    {
//        $file = 'test.csv';
        $file = '795.csv';

        $path = $this->container->get('kernel')->getProjectDir() . '/public/' . $file;
        $reader = Reader::createFromPath($path);
        $reader->setDelimiter(';');
        $reader->setHeaderOffset(0);
        $header = [
            'header', 'type_tyres', 'year', 'vendor', 'model', 'width_prof', 'height_prof',
            'height_tyres', 'diametr_mm', 'diametr_inch', 'komerc', 'seasonality',
            'condition', 'count', 'thorns', 'rating', 'speed', 'load', 'mud_at',
            'mud_mt', 'axis', 'camera', 'radius', 'availability', 'order_by', 'tra',
            'lt', 'description', 'pictures', 'wholesale', 'region', 'city', 'youtube'
        ];
        $records = $reader->getRecords($header);

        foreach ($records as $offset => $record) {

//            dump($record);

            $manufacturer = new Manufacturer();
            $manufacturer->setName(mb_convert_encoding($record['vendor'], 'UTF-8', 'Windows-1252'));
            $this->em->persist($manufacturer);

            $seasonality = new Seasonality();
            $seasonality->setName($record['seasonality']);
            $this->em->persist($seasonality);

            $thorn = new Thorn();
            $thorn->setName($record['thorns']);
            $this->em->persist($thorn);

            $tyre = new Tyre();
            $tyre->setDiameter((int) $record['diametr_mm']);
            $tyre->setHeight((int) $record['height_prof']);
            $tyre->setWidth($record['width_prof'] == "" ? (int) $record['width_prof'] : 0);
            $tyre->setCount($record['count'] == "" ? (int) $record['count'] : 0);
            $tyre->setManufacturers($manufacturer);
            $tyre->setSeasonalitys($seasonality);
            $tyre->setThorns($thorn);
            $this->em->persist($tyre);
        }

        $this->em->flush();
    }
}