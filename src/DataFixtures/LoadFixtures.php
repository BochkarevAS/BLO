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

        $this->addPartsRelation($manager);

//        $this->addCounty($manager);         // Округ
//        $this->addRegion($manager);         // Регион
//        $this->addCompany($manager);        // Компания
//        $this->addNews($manager);           // Новость
//        $this->addNewsCategoeys($manager);  // Категория новостей
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