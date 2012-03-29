<?php

namespace Oxygen\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType {

  public $type, $app;

  public function __construct($app = 'front', $type = 'new') {
    $this->type = $type;
    $this->app = $app;
  }

  public function buildForm(FormBuilder $builder, array $options) {
    $builder->add('username');

    switch ($this->app) {
      case 'admin':
        if ($this->type == 'new')
          $builder->add('password', 'password');
        $builder->add('email', 'email')
                ->add('active', 'checkbox', array('required' => false))
                ->add('role_objects', 'entity', array(
                    'class' => 'OxygenUserBundle:Role',
                    'expanded' => true,
                    'multiple' => true
                ));
        break;
      case 'front':
        if ($this->type == 'new') {
          $builder->add('password', 'repeated', array(
                      'type' => 'password',
                      'first_name' => "Password",
                      'second_name' => "Re-enter Password",
                      'invalid_message' => "The passwords do not match"
                  ))
                  ->add('email', 'repeated', array(
                      'type' => 'email',
                      'first_name' => "Email address",
                      'second_name' => "Re-enter Email",
                      'invalid_message' => "The email addresses do not match"
                  ));
        } else
          $builder->add('email', 'email');
        break;
    }
  }

  public function getName() {
    return 'user';
  }

  public function getDefaultOptions(array $options) {
    return array('data_class' => 'Oxygen\UserBundle\Entity\User');
  }

}
