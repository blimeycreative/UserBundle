<?php

namespace Oxygen\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository implements UserProviderInterface {


  public function loadUserByUsername($username) {
    $user = $this->createQueryBuilder('u')
            ->select('u, r')
            ->leftJoin('u.roles', 'r')
            ->where('u.username = :username OR u.email = :username')
            ->setParameter('username', $username)
            ->getQuery();
    try {
      $user = $user->getSingleResult();
    } catch (NoResultException $exc) {
      throw new UsernameNotFoundException(sprintf('Unable to find an active OxygenUserBundle:User object identified by %s', $username));
    }
    return $user;
  }

  public function refreshUser(UserInterface $user) {
    $class = get_class($user);
    if (!$this->supportsClass($class))
      throw new UnsupportedUserException(sprintf('instances of class %s are not supported', $class));
    return $this->loadUserByUsername($user->getUsername());
  }

  public function supportsClass($class) {
    return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
  }

  public function getAllUsers($container,$paginate = true) {
    $query = $this->createQueryBuilder('u')
            ->select('u, r')
            ->leftJoin('u.roles', 'r'); 
    
    return $query->getQuery()->getResult();
  }

}