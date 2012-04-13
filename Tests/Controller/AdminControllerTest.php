<?php

namespace Oxygen\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Role\Role;
use JMS\SecurityExtraBundle\Security\Authentication\Token\RunAsUserToken;

class AdminControllerTest extends WebTestCase
{

//  EXAMPLE TEST THAT YOU MIGHT CARRY OUT FOR YOUR USER ENTITY
//  
//    private $_container;
//
//    public function setUp()
//    {
//        $kernel = static::createKernel();
//        $kernel->boot();
//        $this->_container = $kernel->getContainer();
//    }
//
//    private function getAuthenticatedUser()
//    {
//        $client = static::createClient();
//        $firewall = $this->_container->getParameter('security.firewall.name');
//        $client->getCookieJar()->set(new \Symfony\Component\BrowserKit\Cookie(session_name(), true));
//        $token = new UsernamePasswordToken('user', null, $firewall, array('ROLE_ADMIN'));
//        self::$kernel->getContainer()->get('session')->set('_security_' . $firewall, serialize($token));
//
//        return $client;
//    }
//
//    public function testIndex()
//    {
//        $client = $this->getAuthenticatedUser();
//
//        $crawler = $client->request('GET', '/admin/user/');
//
//        $this->assertTrue($crawler->filter('html:contains("Manage users")')->count() > 0);
//    }
//
//    public function testUserManagement()
//    {
//        $client = $this->getAuthenticatedUser();
//
//        $crawler = $client->request('GET', '/admin/user');
//
//        /* ---- Create new user ---- */
//        $link = $crawler->selectLink('Create')->link();
//        $crawler = $client->click($link);
//        $form = $crawler->selectButton('Save user')->form();
//        $client->submit($form, array(
//            'user[username]' => 'testUsertest',
//            'user[password]' => 'test',
//            'user[email]' => 'test@test.com',
//            'user[active]' => '1',
//            'user[role_objects][1]' => '1'
//        ));
//        $crawler = $client->followRedirect(true);
//        $row = $crawler->filter('tr.row_testUsertest');
//        $this->assertTrue($row->count() == 1);
//
//        /* ---- Edit user ---- */
//        $link = $row->selectLink('Edit')->link();
//        $crawler = $client->click($link);
//        $form = $crawler->selectButton('Save user')->form();
//        $client->submit($form, array(
//            'user[username]' => 'testUser',
//            'user[email]' => 'test@test.com',
//            'user[active]' => '1',
//            'user[role_objects][1]' => '1'
//        ));
//        $crawler = $client->followRedirect(true);
//        $row = $crawler->filter('tr.row_testUser');
//        $this->assertTrue($row->count() == 1);
//
//        /* ---- Delete user ---- */
//        $form = $row->filter('td.actions_testUser')->selectButton('delete')->form();
//        $client->submit($form);
//        $crawler = $client->followRedirect(true);
//        $this->assertTrue($crawler->filter('tr.row_testUser')->count() == 0);
//    }

}
