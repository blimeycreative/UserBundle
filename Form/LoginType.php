<?php

namespace Oxygen\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LoginType extends AbstractType {

  public function buildForm(FormBuilder $builder, array $options) {
    $builder->add('_username')
            ->add('_password', 'password')
            ->add('_remember_me', 'checkbox', array('required' => false));
  }

  public function getName() {
    return 'login';
  }

}