<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use App\Entity\MicroPost;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user1= new User();
        $user1->setEmail('sara@email.com');
        $user1->setPassword('12345678');
        $manager->persist($user1);

        $user2= new User();
        $user2->setEmail('soli@email.com');
        $user2->setPassword('12345678');
        $manager->persist($user2);
        
        $micropost1= new MicroPost();
        $micropost1->setTitle('Welcome to Poland');
        $micropost1->setText('this is text From Poland');
        $micropost1->setCreatedAt(new DateTimeImmutable());
        $micropost1->setAuthor($user1);
        $manager->persist($micropost1);

        $micropost2= new MicroPost();
        $micropost2->setTitle('Welcome to Paris');
        $micropost2->setText('this is text From Paris');
        $micropost2->setCreatedAt(new DateTimeImmutable());
        $micropost2->setAuthor($user2);
        $manager->persist($micropost2);

        $micropost3= new MicroPost();
        $micropost3->setTitle('Welcome to Iran');
        $micropost3->setText('this is text From Iran');
        $micropost3->setCreatedAt(new DateTimeImmutable());
        $micropost3->setAuthor($user1);
        $manager->persist($micropost3);

        $manager->flush();
    }
}
