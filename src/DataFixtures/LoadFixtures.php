<?php

namespace App\DataFixtures;

use App\Entity\Administration\News;
use App\Entity\Administration\NewsCategories;
use App\Entity\Client\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadFixtures extends Fixture
{
    private $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();
        $this->addNews($manager);
        $this->addNewsCategoeys($manager);
        $this->addCompany($manager);
    }

    private function addNews($manager)
    {
        for ($i = 1; $i <= 100; $i++) {
            $news = new News();
            $news->setName($this->faker->creditCardType());
            $news->setImg($this->faker->imageUrl($width = 640, $height = 480));
            $news->setTitle($this->faker->text($maxNbChars = 20));
            $news->setIdCompany($this->faker->numberBetween(1, 10));
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