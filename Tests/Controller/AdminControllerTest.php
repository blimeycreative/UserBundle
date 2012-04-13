<?php

namespace Oxygen\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Role\Role;
use JMS\SecurityExtraBundle\Security\Authentication\Token\RunAsUserToken;

class AdminControllerTest extends WebTestCase
{
    //EXAMPLE TEST THAT YOU MIGHT CARRY OUT FOR YOUR USER ENTITY

    /*private $_container;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->_container = $kernel->getContainer();
    }

    private function getAuthenticatedUser()
    {
        $client = static::createClient();
        $firewall = $this->_container->getParameter('security.firewall.name');
        $client->getCookieJar()->set(new \Symfony\Component\BrowserKit\Cookie(session_name(), true));
        $token = new UsernamePasswordToken('user', null, $firewall, array('ROLE_ADMIN'));
        self::$kernel->getContainer()->get('session')->set('_security_' . $firewall, serialize($token));

        return $client;
    }
        
    public function testUserManagement()
    {
        echo "\n\n ===START USER TEST===\n\n";
        
        $client = $this->getAuthenticatedUser();
        echo "User test: Spoof login: Pass\n";
        
        $crawler = $client->request('GET', '/admin/user');
        $this->assertTrue(200 == $client->getResponse()->getStatusCode(), 'User index page does not exist');
        echo "User test: Page exists: 200 status - Pass\n";

        $em = $this->_container->get('doctrine.orm.entity_manager');
        $role = $em->getRepository('OxygenUserBundle:Role')
            ->createQueryBuilder('r')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
        $this->assertTrue(is_object($role),'Role is not a doctrine object');
        $this->assertTrue(method_exists($role,'getId'),'Role does not have getId method');
        echo "User test: Get role object: {$role->getRole()} - Pass\n";
        
        $crawler = $client->click($crawler->selectLink('Create')->link());
        $form = $crawler->selectButton('Save user')->form();
        $form['user[username]'] = 'Functional test User';
        $form['user[password]'] = 'test';
        $form['user[email]'] = 'Functional@test';
        $form['user[active]'] = '1';
        $form["user[role_objects][{$role->getId()}]"]->tick();
        $crawler = $client->submit($form);
        $this->assertRegExp('/You must provide a valid email address/', $client->getResponse()->getContent(), 'Error message for fake email not displaying');
        echo "User test: False email validation: Pass\n";
        
        $client->submit($crawler->selectButton('Save user')->form(), array(
            'user[password]' => 'test',
            'user[email]' => 'Functional@test.com',
        ));
        $crawler = $client->followRedirect();
        $row = $crawler->filter('tr:contains("Functional test User")');
        $this->assertTrue($row->count() == 1, 'Test user name cannot be found, likely entity failure');
        echo "User test: Enitity creation: Pass\n";

        $this->assertTrue($row->filter('td:contains("'.$role->getName().'")')->count() == 1, 'Test role cannot be found');
        echo "User test: Correct Role: Associated - Pass\n";

        $crawler = $client->click($row->selectLink('Edit')->link());
        $form = $crawler->selectButton('Save user')->form();
        $client->submit($form, array(
            'user[username]' => 'Functional test User 2',
        ));
        $crawler = $client->followRedirect();
        $row = $crawler->filter('tr:contains("Functional test User 2")');
        $this->assertTrue($row->count() == 1, 'User name has not been updated');
        echo "User test: Entity update: Pass\n";

        $client->submit($row->selectButton('delete')->form());
        $crawler = $client->followRedirect();
        $this->assertTrue($crawler->filter('tr:contains("Functional test User 2")')->count() == 0, 'Instance of user still exists');
        echo "User test: Delete: Pass\n\n ===END USER TEST===\n\n";
    }*/

}
