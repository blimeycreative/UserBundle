<?php

namespace Oxygen\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ResetPasswordType extends AbstractType {

  public function buildForm(FormBuilder $builder, array $options) {
    $builder->add('password', 'repeated', array(
        'type' => 'password',
        'first_name' => "New password",
        'second_name' => "Re-enter Password",
        'invalid_message' => "The passwords do not match"
    ));
  }

  public function getName() {
    return 'reset_password';
  }

}