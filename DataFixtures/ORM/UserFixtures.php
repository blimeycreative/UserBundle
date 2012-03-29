<?php

namespace Oxygen\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Oxygen\UserBundle\Entity\User;
use Oxygen\UserBundle\Entity\Role;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface{
  public function load(ObjectManager $manager){
    $user1 = new User();
    $user1->setUsername('administrator');
    $user1->setSalt($user1->random());
    $user1->setEmail('administrator@admin.com');
    $user1->setActive(1);
    $user1->setPassword(hash('sha512', "password{{$user1->getSalt()}}"));
    $user1->addRole($manager->merge($this->getReference('ROLE_ADMIN')));
    $manager->persist($user1);
    
    $user2 = new User();
    $user2->setUsername('user');
    $user2->setSalt($user2->random());
    $user2->setEmail('user@user.com');
    $user2->setActive(1);
    $user2->setPassword(hash('sha512', "password{{$user2->getSalt()}}"));
    $user2->addRole($manager->merge($this->getReference('ROLE_USER')));
    $manager->persist($user2);
    
    $manager->flush();
  }
  
  public function getOrder(){
    return 2;
  }
}
