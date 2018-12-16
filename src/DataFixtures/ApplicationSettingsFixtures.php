<?php

namespace App\DataFixtures;

use App\Entity\ApplicationSettings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ApplicationSettingsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create();

        $applicationSettings = (new ApplicationSettings())
            ->setEmail('admin@mail.dev')
            ->setWebsiteName('Victor Mendele')
            ->setTagline($faker->sentence(4))
        ;

        $manager->persist($applicationSettings);

        $manager->flush();
    }
}
