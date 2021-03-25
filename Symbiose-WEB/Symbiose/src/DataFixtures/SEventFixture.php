<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\SpecialEvent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SEventFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++){
            $sevent = new SpecialEvent();
            $sevent->setName($faker->words(2,true));
            $sevent->setSupplier($faker->words(1,true));
            $sevent->setType("Tennis");
            $sevent->setDate($faker->dateTime);
            $sevent->setState($faker->boolean);
            $sevent->setNumParticipants(100);
            $sevent->setNumRemaining(0);
            $sevent->setImageFile(null);
            $sevent->setImageName("placeholder");
            $sevent->setImageSize(0);
            $sevent->setUpdatedAt($faker->dateTime);
            $manager->persist($sevent);
        }
        $manager->flush();
    }
}