<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ProjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 15; $i++) {
            $project = (new Project())
                ->setTitle($faker->words(2, true))
                ->setDescription($faker->sentences(2, true))
                ->setBody($faker->sentences(70, true))
                ->setFilename(null)
                ->setDoneAt($faker->dateTime())
                ;

            $manager->persist($project);
        }

        $manager->flush();
    }
}
