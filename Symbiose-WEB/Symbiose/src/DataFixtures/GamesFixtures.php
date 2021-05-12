<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Role;
use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\DateTime;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class GamesFixtures extends Fixture
{
//    private $encoder;
//
//    public function __construct(UserPasswordEncoderInterface $encoder)
//    {
//        $this->encoder = $encoder;
//    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        $user= new User();
            for ($i = 1; $i <= 10; $i++) {
                $game = new Game();
                $game->setName("Match".rand(0,100));
                $game->setTime(new \DateTime('2021-03-15'));
                $game->setUser($this->getReference($user->getUsername()));

                $manager->persist($game);

            }
            $manager->flush();
        }
    }
