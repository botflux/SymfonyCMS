<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $baseCategory = new Category();
        $baseCategory->setName('Base');
        $manager->persist($baseCategory);

        for ($i = 0; $i < 5; $i ++) {
            $category = new Category();
            $category->setName($faker->words(1, true));
            $manager->persist($category);
        }

        $manager->flush();
    }
}
