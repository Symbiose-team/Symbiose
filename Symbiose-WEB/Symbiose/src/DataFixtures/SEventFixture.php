<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\SpecialEvent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SeventFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 5; $i++){
            $sevent = new SpecialEvent();
            $sevent->setName($faker->words(3,true));
            //$sevent->setSupplier("Symbiose");
            $sevent->setType("Special");
            $sevent->setDate($faker->dateTime);
            $sevent->setState(1);
            $sevent->setNumParticipants(100);
            $sevent->setNumRemaining(100);
            $manager->persist($sevent);
        }
        $manager->flush();
    }
}
