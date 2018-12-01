<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin
            ->setEmail('admin@mail.dev')
            ->setPassword($this->passwordEncoder->encodePassword($admin, 'secret'))
            ->setRole('ROLE_ADMIN')
        ;

        $manager->persist($admin);

        $user = new User();
        $user
            ->setEmail('user@mail.dev')
            ->setPassword($this->passwordEncoder->encodePassword($user, 'secret'))
            ->setRole('ROLE_USER')
        ;

        $manager->persist($user);

        $manager->flush();
    }
}
