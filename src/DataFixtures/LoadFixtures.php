<?php

namespace App\DataFixtures;

use App\Entity\Administration\News;
use App\Entity\Administration\NewsCategories;
use App\Entity\Parts\Oem;
use App\Entity\Region\City;
use App\Entity\Client\Company;
use App\Entity\Region\County;
use App\Entity\Region\Region;
use App\Entity\Client\Vendor;
use App\Entity\Parts\Carcase;
use App\Entity\Parts\Engine;
use App\Entity\Parts\Brand;
use App\Entity\Parts\Model;
use App\Entity\Parts\Part;
use App\Entity\Tyres\Manufacturer;
use App\Entity\Tyres\Seasonality;
use App\Entity\Tyres\Thorn;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\bg_BG\Payment;
use Faker\Provider\da_DK\Person;
use Faker\Provider\fr_FR\Address;

class LoadFixtures extends Fixture
{
    private $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();
        $this->faker->addProvider(new Address($this->faker));
        $this->faker->addProvider(new Payment($this->faker));
        $this->faker->addProvider(new Person($this->faker));

        $this->addTyresRelation($manager);  // Шины
//        $this->addPartsRelation($manager);  // Запчасти

//        $this->addCounty($manager);         // Округ
//        $this->addRegion($manager);         // Регион
//        $this->addCompany($manager);        // Компания
//        $this->addNews($manager);           // Новость
//        $this->addNewsCategoeys($manager);  // Категория новостей
    }

    private function addTyresRelation($manager)
    {
        $manufacturers = [
            "Amtel", "BFGoodrich", "Brasa", "Bridgestone", "Continental", "Cordiant",
            "Dmack", "Dunlop", "Firestone", "Formula", "FORWARD", "General Tire", "Gislaved",
            "Goodyear", "Hankook", "Jinyu", "Marshal", "Matador", "Maxxis", "Nankang", "Nexen",
            "Nitto", "Nokian", "Pirelli", "PROFIL", "Riken", "Roadstone", "Rosava", "Sailun",
            "Sava", "Tigar", "Toyo", "Triangle Group", "Tunga", "Viatti", "Yokohama"
        ];
        $seasonalitys = ['Зима', 'Лето', 'Всесезонные'];
        $thorns = ['Шипованные', 'Без шипов'];
        $models = [
            'AS-1', 'CW-20', 'CW-25', 'CX-668', 'ECO-1', 'ECO-2', 'ESSN-1',
            'FT-4', 'FT-7', 'IA-1', 'Mudstar Radial M/T', 'N-605', 'N-830',
            'N-889', 'N-890', 'N-990', 'NR-066', 'NS-1', 'NS-2', 'NS-20',
            'NS-2R', 'RX-615', 'S-600', 'S-900', 'SL-6', 'SN-1', 'SNC-1',
            'Snow Viva SV-1', 'SP-5', 'SP-7', 'SV-1', 'SV-2', 'SV-55', 'SW-5',
            'SW-7', 'WA-1', 'XR-611', 'NS-2 Ultra Sport'
        ];
        $vendors = [
            '«ЛегионТрейд»', 'АВТОМАРКЕТ', 'ЛЕВОБЕРЕЖНЫЙ', 'Авторесурс-Сервис', 'Стол заказов', 'Контрактавто',
            'Штутгарт', '1-й Автомаркет Запчастей', '100 процентов', '1000 запчастей', '159AVTO', '25 All Auto',
            '38РЕГИОН', '4 Такта', '4x4cars', '4 Runner', 'a-ligaPRO', 'Abs-auto', 'Ads54', 'ADX-Motors',
            'AGIRA', 'Airbag102', 'AKPP-MARKET', 'AlexAuto', 'ALFACAR', 'Alphagarage', 'AlphaParts',
            'Amotomo', 'AmourMotor', 'Aprice72.ru', 'Arsenal Auto', 'AsiaTrek'
        ];
        $i = 1;

        foreach ($vendors as $record) {
            $vendor = new \App\Entity\Tyres\Vendor();
            $vendor->setName(mb_convert_encoding($record, 'UTF-8', 'Windows-1252'));
            $manager->persist($vendor);
        }

        foreach ($manufacturers as $record) {
            $manufacturer = new Manufacturer();
            $manufacturer->setName(mb_convert_encoding($record, 'UTF-8', 'Windows-1252'));
            $this->setReference('manufacturer_' . $i, $manufacturer);
            $manager->persist($manufacturer);
            $i++;
        }

        foreach ($models as $record) {
            $model = new \App\Entity\Tyres\Model();
            $model->setName(mb_convert_encoding($record, 'UTF-8', 'Windows-1252'));
            $model->setManufacturers($this->getReference('manufacturer_' . $this->faker->numberBetween(1, count($models)-2)));
            $manager->persist($model);
        }

        foreach ($seasonalitys as $record) {
            $seasonality = new Seasonality();
            $seasonality->setName(mb_convert_encoding($record, 'UTF-8', 'Windows-1252'));
            $manager->persist($seasonality);
        }

        foreach ($thorns as $record) {
            $thorn = new Thorn();
            $thorn->setName(mb_convert_encoding($record, 'UTF-8', 'Windows-1252'));
            $manager->persist($thorn);
        }

        $manager->flush();
    }

    private function addPartsRelation($manager)
    {
        $brands = [
            'Toyota', 'Nissan', 'Subaru', 'JIP', 'Audi',
            'Jaguar', 'Ferrari', 'Hammer', 'Lexus', 'Mazda'
        ];

        $vendors = [
            'Владмоторс', 'Гугл', 'Яндекс', 'Apple', 'HP',
            'Droom', 'Japancar', 'Coca-cola', 'ВК', 'Бимбило'
        ];

        $citys = [
            'Владивосток', 'Хабаровск', 'Москва', 'Находка', 'Иркутск',
            'Новосебирск', 'Пенза', 'Ростов-на-Дону', 'Якутск', 'Уссурийск'
        ];

        for ($i = 1; $i <= 10; $i++) {
            $brand = new Brand();
            $brand->setName($brands[$i-1]);
            $this->setReference('brand_' . $i, $brand);
            $manager->persist($brand);

            $city = new City();
            $city->setName($citys[$i-1]);
            $this->setReference('city_' . $i, $city);
            $manager->persist($city);

            $vendor = new Vendor();
            $vendor->setName($vendors[$i-1]);
            $this->setReference('vendor_' . $i, $vendor);
            $manager->persist($vendor);
        }

        for ($i = 1; $i <= 50; $i++) {
            $part = new Part();
            $part->setName("Фара_$i");
            $part->addBrand($this->getReference('brand_' . $this->faker->numberBetween(1, 10)));
            $manager->persist($part);

            $oem = new Oem();
            $oem->setName('OEM' . $this->faker->cpr);
            $oem->setParts($part);
            $oem->setCitys($this->getReference('city_' . $this->faker->numberBetween(1, 10)));
            $oem->setVendors($this->getReference('vendor_' . $this->faker->numberBetween(1, 10)));
            $manager->persist($oem);

            for ($k = 1; $k <= 10; $k++) {
                $model = new Model();
                $model->setName($this->faker->departmentName);
                $part->addModel($model);
                $manager->persist($model);
            }

            for ($j = 1; $j <= 5; $j++) {
                $engine = new Engine();
                $engine->setName('EN' . $this->faker->vat);
                $part->addEngine($engine);
                $manager->persist($engine);

                $carcase = new Carcase();
                $carcase->setName('CAR' . $this->faker->vat);
                $part->addCarcase($carcase);
                $manager->persist($carcase);
            }

            $manager->flush();
        }
    }

    private function addCounty($manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $country = new County();
            $country->setName($this->faker->country);
            $this->setReference('country_' . $i, $country);
            $this->listCounty[] = $country;

            $manager->persist($country);
        }

        $manager->flush();
    }

    private function addRegion($manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $region = new Region();
            $region->setName($this->faker->region);
            $this->setReference('region_' . $i, $region);
            $this->listRegion[] = $region;

            $manager->persist($region);
        }

        $manager->flush();
    }

    private function addNews($manager)
    {
        for ($i = 1; $i <= 100; $i++) {
            $news = new News();
            $news->setName($this->faker->creditCardType());
            $news->setImg($this->faker->imageUrl($width = 640, $height = 480));
            $news->setTitle($this->faker->text($maxNbChars = 20));
            $news->setIdCompany($this->getReference('company_' . $this->faker->numberBetween(1, 10)));
            $news->setUid($this->faker->numberBetween(1, 100));
            $news->setDisplay($this->faker->numberBetween(0, 1));
            $news->setDisplayOnMain($this->faker->numberBetween(0, 1));
            $news->setTypeNews($this->faker->numberBetween(1, 10));
            $news->setMassage($this->faker->text($maxNbChars = 50));
            $this->setReference('news_' . $i, $news);

            $manager->persist($news);
        }

        $manager->flush();
    }

    private function addNewsCategoeys($manager)
    {
        for ($i = 1; $i <= 100; $i++) {
            $newsCategories = new NewsCategories();
            $newsCategories->setName($this->faker->creditCardType());
            $newsCategories->setDisplayOnMain($this->faker->numberBetween(0, 1));
            $newsCategories->setDisplay($this->faker->numberBetween(0, 1));
            $newsCategories->setRating($this->faker->numberBetween(1, 10));
            $this->setReference('news_categories_' . $i, $newsCategories);
            $manager->persist($newsCategories);
        }

        $manager->flush();
    }

    private function addCompany($manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $company = new Company();
            $company->setName($this->faker->creditCardType());
            $this->setReference('company_' . $i, $company);
            $manager->persist($company);
        }

        $manager->flush();
    }
}