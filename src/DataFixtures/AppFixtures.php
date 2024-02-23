<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setName('Jean');
        $user1->setEmail('jean@mail.com');
        $user1->setRoles(['ROLE_USER']);
        $user1->setAvatar('https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp');

        $password1 = $this->hasher->hashPassword($user1, 'pass_1234');
        $user1->setPassword($password1);

        $user2 = new User();
        $user2->setName('John');
        $user2->setEmail('john@mail.com');
        $user2->setRoles(['ROLE_USER']);
        $user2->setAvatar('https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp');

        $password2 = $this->hasher->hashPassword($user2, 'pass_1234');
        $user2->setPassword($password2);

        $user3 = new User();
        $user3->setName('Alicia');
        $user3->setEmail('alicia@mail.com');
        $user3->setRoles(['ROLE_USER']);
        $user3->setAvatar('https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava5-bg.webp');

        $password3 = $this->hasher->hashPassword($user3, 'pass_1234');
        $user3->setPassword($password3);

        $user4 = new User();
        $user4->setName('Kate');
        $user4->setEmail('kate@mail.com');
        $user4->setRoles(['ROLE_USER']);
        $user4->setAvatar('https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava2-bg.webp');

        $password4 = $this->hasher->hashPassword($user4, 'pass_1234');
        $user4->setPassword($password4);

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);

        $manager->flush();
    }
}
