<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();

        $user = new User();
        $user
            ->setEmail('user@user.com')
            ->setPassword($this->passwordEncoder->encodePassword($user, 'password'))
        ;

        $manager->persist($user);

        $this->addReference("user", $user);

        $manager->flush();
    }
}
