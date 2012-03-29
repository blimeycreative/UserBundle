<?php

namespace Oxygen\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Oxygen\UserBundle\Form\UserType;
use Oxygen\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @Route("/account")
 */
class ClientController extends Controller {

  /**
   * @Route("/register", name="register")
   * @Template
   */
  public function registerAction() {
    $user = new User();
    $form = $this->createForm(new UserType('front', 'new'), $user);
    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $role = $this->getDoctrine()->getRepository('OxygenUserBundle:Role')->findOneByRole('ROLE_USER');
        $user->setActive(0);
        $user->addRole($role);
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
        $user->setPassword($password);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();
        $message = \Swift_Message::newInstance()
                ->setSubject('Account confirmation')
                ->setTo($user->getEmail())
                ->setFrom('test@test.com')
                ->setBody($this->renderView('OxygenUserBundle:Email:register.html.twig', array('user' => $user)), 'text/html');
        $this->get('mailer')->send($message);
        $this->get('session')->setFlash('notice', 'Thank you, you must now confirm your account');
        $thankyou = $this->thankyouAction("Thank you for registering for an account, and email has been sent to your account with a link.  Please click the link to confirm your account.");
        return $thankyou;
      }
    }
    return array('form' => $form->createView());
  }

  /**
   * @Route("/register/thank-you", name="register_thankyou")
   * @Template
   */
  public function thankyouAction($message) {
    return $this->render('OxygenUserBundle:Client:thankyou.html.twig', array(
        'message' => $message
        ));
  }

  /**
   * @Route("/confirm/{id}/{token}", name="register_confirm")
   * @Template
   */
  public function confirmAction($id, $token) {
    $user = $this->getDoctrine()
            ->getRepository('OxygenUserBundle:User')
            ->findOneBy(array('id' => $id, 'token' => $token));
    if (!$user)
      throw $this->createNotFoundException("Sorry this request is not valid, if you followed an email link please contact the site administrator");
    $user->setActive(1);
    $em = $this->getDoctrine()->getEntityManager();
    $em->persist($user);
    $em->flush();
    $token = new UsernamePasswordToken($user, null, 'secured_area', $user->getRoles());
    $this->get('security.context')->setToken($token);
    $this->get('session')->setFlash('notice','Your account has been confirmed and you are now logged in');
    return new RedirectResponse($this->generateUrl('account_show'));
  }

  /**
   * @Route("/", name="account_show")
   * @Secure(roles="ROLE_USER")
   * @Template
   */
  public function showAction() {
    $user = $this->get('security.context')->getToken()->getUser();
    if (!$user)
      throw $this->createNotFoundException('User account not found');
    return array('user' => $user);
  }
  
  /**
   * @Route("/forgotten-password/{email}", name="forgotten_password")
   */
  public function forgottenPassword($email){
    $user = $this->getDoctrine()->getRepository('user')->findBy(array('username' => $email));
    
    $message = \Swift_Message::newInstance()
                ->setSubject('Forgotten Password')
                ->setTo($user->getEmail())
                ->setFrom('test@test.com')
                ->setBody($this->renderView('OxygenUserBundle:Email:forgotten_password.html.twig', array('user' => $user)), 'text/html');
    
  }

}
