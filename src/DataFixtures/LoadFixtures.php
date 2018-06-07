<?php

namespace App\DataFixtures;

use App\Entity\Administration\News;
use App\Entity\Administration\NewsCategories;
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
    }

    private function addNews($manager)
    {
        for ($i = 1; $i <= 100; $i++) {
            $news = new News();
            $news->setName($this->faker->creditCardType());
            $news->setImg($this->faker->imageUrl($width = 640, $height = 480));
            $news->setTitle($this->faker->text($maxNbChars = 50));
            $news->setCompany($this->faker->creditCardType());
            $news->setUid($this->faker->numberBetween(1, 100));
            $news->setDisplay($this->faker->numberBetween(0, 1));
            $news->setDisplayOnMain($this->faker->numberBetween(0, 1));
            $news->setTypeNews($this->faker->numberBetween(1, 10));
            $news->setCreatedAt(new \DateTime());
            $this->setReference('news_' . $i, $news);
            $manager->persist($news);
        }

        $manager->flush();
    }

    private function addNewsCategoeys($manager)
    {
        for ($i = 1; $i <= 100; $i++) {
            $NewsCategories = new NewsCategories();
            $NewsCategories->setName($this->faker->creditCardType());
            $NewsCategories->setDisplayOnMain($this->faker->numberBetween(0, 1));
            $NewsCategories->setDisplay($this->faker->numberBetween(0, 1));
            $NewsCategories->setRating($this->faker->numberBetween(1, 10));
            $this->setReference('news_categories_' . $i, $NewsCategories);

            $manager->persist($NewsCategories);
        }

        $manager->flush();
    }
}