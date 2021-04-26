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

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        $genres=['male','female'];
        $genre = $faker->randomElement($genres);
        $adminRole = new Role();
        $fournisseurRole = new Role();
        $clientRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $fournisseurRole->setTitle('ROLE_FOURNISSEUR');
        $clientRole->setTitle('ROLE_CLIENT');
        $manager->persist($adminRole);
        $manager->persist($fournisseurRole);
        $manager->persist($clientRole);

        $adminUser = new User();
        $adminUser->setFirstName('Skander')
            ->setLastName('Thabet')
            ->setEmail('skander.thabet@esprit.tn')
            ->setHash($this->encoder->encodePassword($adminUser, 'password'))
            ->setPicture('https://unavatar.now.sh/skander.thabet@esprit.tn')
            ->setCin(125478963)
            ->setBirthday($faker->dateTime)
            ->setRole('Admin')
            ->setAdresse('Tunis Ariana')
            ->setPhoneNumber(258965418)
            ->setIsVerified(true)
            ->setIsEnabled(true)
            ->setGenre("Homme")
            ->addUserRole($adminRole);
        $manager->persist($adminUser);

        $adminUserV2 = new User();
        $adminUserV2->setFirstName('Admin')
            ->setLastName('Admin')
            ->setEmail('admin@symbiose.tn')
            ->setHash($this->encoder->encodePassword($adminUser, 'password'))
            ->setPicture('https://unavatar.now.sh/reddit.com')
            ->setCin(666888774)
            ->setBirthday($faker->dateTime)
            ->setRole('Admin')
            ->setAdresse('Tunis Ariana')
            ->setPhoneNumber(214455875)
            ->setIsVerified(true)
            ->setIsEnabled(true)
            ->setGenre("Femme")
            ->addUserRole($adminRole);
        $manager->persist($adminUserV2);


        //$slugify = new Slugify();

        $users = [];
        $genres = ['male', 'female'];
        $lesroles = ['Fournisseur', 'Client'];
        $registeredAt=DateTime::date("now");
        $isVerified=[true,false];
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $r = $faker->randomElement($lesroles);
            $genre = $faker->randomElement($genres);
            $isVerified= $faker->boolean(50);
            $picture = "https://randomuser.me/api/portraits/";
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstName($genre))
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setAdresse($faker->address)
                ->setBirthday($faker->dateTime)
                ->setCin($faker->randomDigit)
                ->setGenre($genre)
                ->setPhoneNumber($faker->regexify('(216)?[0-9]{8}'))
                ->setHash($hash)
                ->setPicture($picture)
                ->setIsVerified($isVerified)
                ->setIsEnabled(true)
                ->setRole($r);
            if ($r == 'Fournisseur') {
                $user->addUserRole($fournisseurRole);
                    #    $this->addReference($user->getUsername(),$user);
                $this->addReference($user->getUsername(),$user);
                $manager->persist($user);
                $users[] = $user;
            } else {
                $user->addUserRole($clientRole);
                $this->addReference($user->getUsername(),$user);
                $manager->persist($user);
                $users[] = $user;
            }
            if($genre=='female'){
                $user->setGenre('Femme');
                $manager->persist($user);
            }
            else{
                $user->setGenre("Homme");
                $manager->persist($user);
            }


            $manager->flush();
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
}
