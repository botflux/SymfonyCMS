<?php

namespace App\DataFixtures;

use App\Entity\LearningSubject;
use App\Repository\TagRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LearningSubjectFixtures extends Fixture
{
    /**
     * @var TagRepository
     */
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i ++) {
            $learningSubject = new LearningSubject();
            $learningSubject
                ->setTitle($faker->words(1, true))
                ->setDescription($faker->sentences(2, true))
                ->setPriority(rand(1, 4))
            ;

            $manager->persist($learningSubject);
        }

        $manager->flush();
    }
}
