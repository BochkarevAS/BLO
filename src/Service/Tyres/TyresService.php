<?php

namespace App\Service\Tyres;

use App\Entity\Tyres\Brand;
use App\Entity\Tyres\Model;
use App\Entity\Tyres\Picture;
use App\Entity\Tyres\Profile\Count;
use App\Entity\Tyres\Profile\Diameter;
use App\Entity\Tyres\Profile\Height;
use App\Entity\Tyres\Profile\Width;
use App\Entity\Tyres\Seasonality;
use App\Entity\Tyres\Thorn;
use App\Entity\Tyres\Tyre;
use App\Entity\Tyres\Vendor;
use Doctrine\ORM\EntityManager;
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

        $file = 'test.csv';
//        $file = '795.csv';
//        $file = '615.csv';
//        $file = '616.csv';

        $serializer = $this->container->get('serializer');
        $path       = $this->container->get('kernel')->getProjectDir() . '/public/' . DIRECTORY_SEPARATOR . $file;
        $em         = $this->container->get('doctrine.orm.default_entity_manager');

        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        $reader = Reader::createFromPath($path);
        $reader->setDelimiter(';');
        $reader->setHeaderOffset(0);
        $header = [
            'header', 'tire_type', 'year', 'brand', 'model', 'profile_width_mm',
            'profile_height_proc', 'wheel_width_inc', 'wheel_height_inc', 'landing_diameter_mm',
            'landing_diameter_inc', 'commercial', 'seasonality', 'status',
            'quantity', 'thorns', 'ply_rating', 'index_of_speed', 'load_index',
            'mud_at', 'dirt_mt', 'axis', 'presence_of_camera', 'radius', 'moto_class',
            'in_order', 'tra_code', 'lt_tire_function', 'price', 'availability',
            'description', 'pictures', 'opt', 'region', 'city', 'link_youtube'
        ];
        $records = $reader->getRecords($header);
        $i = 0;
        $batchSize = 1000;
        $nameVendor = 'ALFACAR';

        foreach ($records as $offset => $record) {
            $hash = md5(
                $record['landing_diameter_mm'] .
                $record['profile_height_proc'] .
                $record['profile_width_mm'] .
                $record['model'] .
                $record['index_of_speed'] .
                $record['load_index'] .
                $record['pictures'] .
                $record['brand']
            );
            $record = $this->valid($record, $em, $nameVendor);
            $tyre   = $em->getRepository(Tyre::class)->findOneBy(['hash' => $hash]);

            if ($tyre === null) {
                $tyre = new Tyre();
                $this->tyre($tyre, $record, $hash);
                $em->persist($tyre);

                $picture = new Picture();
                $this->json($tyre, $picture, $record['pictures'], $serializer);
                $em->persist($picture);
            } else {
                $this->tyre($tyre, $record, $hash);
                $em->merge($tyre);
                $picture = $em->getRepository(Picture::class)->find($tyre->getId());

                if (!$picture) {
                    $this->json($tyre, $picture, $record['pictures'], $serializer);
                    $em->merge($picture);
                }
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

        $record['seasonality'] = $em->getRepository(Seasonality::class)->findOneBy([
            'name' => mb_convert_encoding($record['seasonality'], 'UTF-8', 'Windows-1251')
        ]);

        $record['quantity'] = $em->getRepository(Count::class)->findOneBy([
            'name' => $record['quantity'] ? $record['quantity'] : 0
        ]);

//        $record['profile_width_mm'] = $em->getRepository(Width::class)->findOneBy([
//            'name' => $record['profile_width_mm'] ? $record['profile_width_mm'] : 0
//        ]);

        $record['profile_height_proc'] = $em->getRepository(Height::class)->findOneBy([
            'name' => $record['profile_height_proc'] ? $record['profile_height_proc'] : 0
        ]);

        $record['landing_diameter_mm'] = $em->getRepository(Diameter::class)->findOneBy([
            'name' => $record['landing_diameter_mm'] ? $record['landing_diameter_mm'] : 0
        ]);

        $record['thorn'] = $em->getRepository(Thorn::class)->findOneBy([
            'name' => mb_convert_encoding($record['thorns'], 'UTF-8', 'Windows-1251')
        ]);

        return $record;
    }

    /**
     * @param Tyre $tyre
     * @param $record
     * @param $hash
     */
    private function tyre($tyre, array $record, $hash)
    {
        $tyre->setDiameter($record['landing_diameter_mm']);
        $tyre->setHeight($record['profile_height_proc']);
        $tyre->setWidth($record['profile_width_mm']);
        $tyre->setQuantity($record['quantity']);
        $tyre->setHash($hash);
        $tyre->addVendors($record['vendor']);
        $tyre->setModels($record['model']);
        $tyre->setBrands($record['brand']);
        $tyre->setSeasonalitys($record['seasonality']);
        $tyre->setThorns($record['thorn']);
        $tyre->setPrice($record['price']);
    }

    /**
     * @param Tyre $tyreId
     * @param Picture $picture
     * @param $serializer
     */
    private function json($tyre, $picture, $linkPicture, $serializer)
    {
        $json = [
            'idProduct'  => $tyre->getId(),
            'idModule'   => 1,
            'imgsJson'   => 0,
            'imgsResult' => 0,
            'imgsLinks'  => mb_convert_encoding($linkPicture, 'UTF-8', 'Windows-1251')
        ];

        $json = $serializer->serialize($json, 'json');

        $picture->setIdModule(1);
        $picture->setTyres($tyre);
        $picture->setPath($json);
    }
}