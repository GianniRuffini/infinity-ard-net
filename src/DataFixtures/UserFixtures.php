<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->encoder = $userPasswordHasherInterface;
    }
    public function load(ObjectManager $manager)
    {
        //ADMIN
        $user = new User();
        $user->setEmail('admin@admin.com');
        $plainPassword = "password";
        $encodedPassword = $this->encoder->hashPassword($user, $plainPassword);
        $user->setPassword($encodedPassword);
        $user->setRoles(["ROLE_USER", "ROLE_ADMIN"]);
        $user->setIsVerified(1);
        $manager->persist($user);

        //SIMPLE USER
        $user = new User();
        $user->setEmail('user@user.com');
        $plainPassword = "password";
        $encodedPassword = $this->encoder->hashPassword($user, $plainPassword);
        $user->setPassword($encodedPassword);
        $user->setRoles(["ROLE_USER"]);
        $user->setIsVerified(1);
        $manager->persist($user);
        $manager->flush();
    }
}
