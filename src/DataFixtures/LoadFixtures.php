<?php

namespace App\DataFixtures;

use App\Entity\Administration\News;
use App\Entity\Administration\NewsCategories;
use App\Entity\Spare\Oem;
use App\Entity\Region\City;
use App\Entity\Client\Company;
use App\Entity\Region\County;
use App\Entity\Region\Region;
use App\Entity\Client\Vendor;
use App\Entity\Spare\Carcase;
use App\Entity\Spare\Engine;
use App\Entity\Spare\Mark;
use App\Entity\Spare\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\bg_BG\Payment;
use Faker\Provider\da_DK\Person;
use Faker\Provider\fr_FR\Address;

class LoadFixtures extends Fixture
{
    private $faker;
    private $listCompanys = [];
    private $listCity     = [];
    private $listRegion   = [];
    private $listVendor   = [];
    private $listCounty   = [];
    private $listOem      = [];
    private $listModel    = [];
    private $listEngine   = [];
    private $listCarcase  = [];

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();
        $this->faker->addProvider(new Address($this->faker));
        $this->faker->addProvider(new Payment($this->faker));
        $this->faker->addProvider(new Person($this->faker));

//        $this->addCarcase($manager);        // Кузов
        $this->addEngine($manager);         // Двигатель
        $this->addModel($manager);          // Модель
//        $this->addOem($manager);            // ОЕМ
//        $this->addCounty($manager);         // Округ
//        $this->addVendor($manager);         // Продавец
//        $this->addCity($manager);           // Город
//        $this->addRegion($manager);         // Регион
//        $this->addCompany($manager);        // Компания
//        $this->addMark($manager);           // Марка
        $this->addNews($manager);           // Новость
        $this->addNewsCategoeys($manager);  // Категория новостей
    }

    private function addMark($manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $mark = new Mark();
            $mark->setName($this->faker->departmentName);
            $mark->setLocationRightLeft($this->faker->numberBetween(0, 2));
            $mark->setLocationBeforeBack($this->faker->numberBetween(0, 2));
            $mark->setLocationUpDown($this->faker->numberBetween(0, 2));
            $mark->setState($this->faker->numberBetween(0, 2));
            $mark->setPresence($this->faker->numberBetween(0, 2));
            $mark->setCityId($this->listCity[array_rand($this->listCity)]);
            $mark->setRegionId($this->listRegion[array_rand($this->listRegion)]);
            $mark->setVendorId($this->listVendor[array_rand($this->listVendor)]);
            $mark->setCountyId($this->listCounty[array_rand($this->listCounty)]);
            $mark->setOemId($this->listOem[array_rand($this->listOem)]);
            $mark->setModelId($this->listModel[array_rand($this->listModel)]);
            $mark->setCarcaseId($this->listCarcase[array_rand($this->listCarcase)]);
            $this->setReference('mark_' . $i, $mark);

            $manager->persist($mark);
        }

        $manager->flush();
    }

    private function addCarcase($manager)
    {
        for ($i = 1; $i <= 50; $i++) {
            $сarcase = new Carcase();
            $сarcase->setName($this->faker->secondaryAddress);
            $this->setReference('сarcase_' . $i, $сarcase);
            $this->listCarcase[] = $сarcase;

            $manager->persist($сarcase);
        }

        $manager->flush();
    }

    private function addEngine($manager)
    {
        for ($i = 1; $i <= 50; $i++) {
            $engine = new Engine();
            $engine->setName($this->faker->cpr);
            $this->setReference('engine_' . $i, $engine);
            $this->listEngine[] = $engine;

            $manager->persist($engine);
        }

        $manager->flush();
    }

    private function addModel($manager)
    {
        for ($i = 1; $i <= 15; $i++) {
            $model = new Model();
            $model->setName($this->faker->departmentName);
            $this->setReference('model_' . $i, $model);
            $this->listModel[] = $model;

            $manager->persist($model);
        }

        $manager->flush();
    }

    private function addOem($manager)
    {
        for ($i = 1; $i <= 50; $i++) {
            $oem = new Oem();
            $oem->setName($this->faker->vat(false));
            $this->setReference('oem_' . $i, $oem);
            $this->listOem[] = $oem;

            $manager->persist($oem);
        }

        $manager->flush();
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

    private function addVendor($manager)
    {
        for ($i = 1; $i <= 25; $i++) {
            $vendor = new Vendor();
            $vendor->setName($this->faker->name);
            $this->setReference('vendor_' . $i, $vendor);
            $this->listVendor[] = $vendor;

            $manager->persist($vendor);
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

    private function addCity($manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $city = new City();
            $city->setName($this->faker->city);
            $this->setReference('city_' . $i, $city);
            $this->listCity[] = $city;

            $manager->persist($city);
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
            $news->setIdCompany($this->listCompanys[array_rand($this->listCompanys)]);
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
            $this->listCompanys[] = $company;

            $manager->persist($company);
        }

        $manager->flush();
    }
}