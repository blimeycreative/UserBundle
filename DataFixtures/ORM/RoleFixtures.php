<?php
/* Example role fixtures
namespace Oxygen\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Oxygen\UserBundle\Entity\Role;
use Doctrine\Common\Persistence\ObjectManager;

class RoleFixtures extends AbstractFixture implements OrderedFixtureInterface{
  public function load(ObjectManager $manager){
    $role1 = new Role();
    $role1->setName('administrator');
    $role1->setRole('ROLE_ADMIN');
    $manager->persist($role1);
    
    $role2 = new Role();
    $role2->setName('user');
    $role2->setRole('ROLE_USER');
    $manager->persist($role2);
    
    $manager->flush();
    
    $this->addReference('ROLE_ADMIN', $role1);
    $this->addReference('ROLE_USER', $role2);
  }
  
  public function getOrder(){
    return 1;
  }
}
*/