<?php

namespace Oxygen\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Oxygen\UserBundle\Form\LoginType;

class SecurityController extends Controller {

  /**
   * @Route("/login/{blank_layout}", name="_login", defaults={"blank_layout" = false})
   * @Template()
   */
  public function loginAction($blank_layout = false) {
    $request = $this->getRequest();
    $session = $request->getSession();
    // get the login error if there is one
    if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
      $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    } else {
      $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
    }

    $form = $this->createForm(new loginType());
    $form->setData(array('_username' => $session->get(SecurityContext::LAST_USERNAME)));
    $params = array('form' => $form->createView(), 'error' => $error);
    if ($blank_layout)
      return $this->render('OxygenUserBundle:Security:login.html.twig', $params);
    return $this->render('OxygenUserBundle:Security:login-form.html.twig', $params);
  }

  /**
   * @Route("/login_check", name="_login_check")
   */
  public function loginCheckAction() {
    
  }

  /**
   * @Route("/logout", name="_logout")
   */
  public function logoutAction() {
    
  }

}
