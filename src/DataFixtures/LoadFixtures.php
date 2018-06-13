<?php

namespace App\DataFixtures;

use App\Entity\Administration\News;
use App\Entity\Administration\NewsCategories;
use App\Entity\Region\City;
use App\Entity\Client\Company;
use App\Entity\Region\Region;
use App\Entity\Client\Vendor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\en_US\Address;

class LoadFixtures extends Fixture
{
    private $faker;
    private $listCompanys = [];

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();
        $faker = new Generator();
        $faker->addProvider(new Address($faker));

        $this->addVendor($manager);
        $this->addCity($manager);
        $this->addRegion($manager);
        $this->addCompany($manager);
        $this->addNews($manager);
        $this->addNewsCategoeys($manager);
    }

    private function addVendor($manager)
    {
        for ($i = 1; $i <= 25; $i++) {
            $vendor = new Vendor();
            $vendor->setName($this->faker->name);
            $this->setReference('vendor_' . $i, $vendor);

            $manager->persist($vendor);
        }

        $manager->flush();
    }

    private function addRegion($manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $region = new Region();
            $region->setName($this->faker->country);
            $this->setReference('region_' . $i, $region);

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