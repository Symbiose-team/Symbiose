<?php

namespace App\DataFixtures;

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
            ->setPhoneNumber(25896541)
            ->addUserRole($adminRole);
        $manager->persist($adminUser);


        //$slugify = new Slugify();

        $users = [];
        $genres = ['male', 'female'];
        $lesroles = ['Fournisseur', 'Client'];
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $r = $faker->randomElement($lesroles);
            $genre = $faker->randomElement($genres);

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
                ->setPhoneNumber($faker->regexify('((\+|00)216)?[0-9]{8}'))
                ->setHash($hash)
                ->setPicture($picture)
                ->setRole($r);
            if ($r == 'Fournisseur') {
                $user->addUserRole($fournisseurRole);
                $manager->persist($user);
                $users[] = $user;
            } else {
                $user->addUserRole($clientRole);
                $manager->persist($user);
                $users[] = $user;
            }


            $manager->flush();
        }
    }
}
