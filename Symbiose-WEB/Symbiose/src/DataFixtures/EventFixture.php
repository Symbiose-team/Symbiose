<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EventFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++){
            $event = new Event();
            $event->setName($faker->words(2,true));
            //$event->setSupplier($faker->words(1,true));
            $event->setType("Tennis");
            $event->setDate($faker->dateTime);
            $event->setState(0);
            $event->setNumParticipants(100);
            $event->setNumRemaining(100);
            $manager->persist($event);
        }
        $manager->flush();
    }
}
