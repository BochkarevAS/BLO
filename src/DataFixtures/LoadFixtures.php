<?php

namespace App\DataFixtures;

use App\Entity\Administration\News;
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
    }

    private function addNews($manager)
    {
        for ($i = 1; $i <= 50; $i++) {
            $news = new News();
            $news->setName($this->faker->creditCardType());
            $news->setImg($this->faker->imageUrl($width = 640, $height = 480));
            $news->setTitle($this->faker->text($maxNbChars = 50));
            $news->setCompany($this->faker->creditCardType());
            $news->setUid($this->faker->numberBetween(1, 100));
            $news->setDisplay($this->faker->numberBetween(1, 2));
            $news->setDisplayOnMain($this->faker->numberBetween(1, 2));
            $news->setTypeNews($this->faker->numberBetween(1, 10));
            $news->setCreatedAt(new \DateTime());
            $this->setReference('news_' . $i, $news);
            $manager->persist($news);
        }

        $manager->flush();
    }
}