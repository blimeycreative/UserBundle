<?php

namespace Oxygen\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ForgottenPasswordType extends AbstractType {

  public function buildForm(FormBuilder $builder, array $options) {
    $builder->add('email','email');
  }

  public function getName() {
    return 'forgotten_password';
  }

}