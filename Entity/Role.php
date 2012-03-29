<?php

namespace Oxygen\UserBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Oxygen\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Oxygen\UserBundle\Entity\Role
 * @ORM\MappedSuperclass
 */
class Role implements RoleInterface {

  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string $name
   *
   * @ORM\Column(name="name", type="string", length=255)
   */
  private $name;

  /**
   * @var string $role
   *
   * @ORM\Column(name="role", type="string", length=255, unique=true)
   */
  private $role;

  /**
   * @ORM\ManyToMany(targetEntity="User", mappedBy="roles")
   */
  private $users;

  public function __construct() {
    $this->users = new ArrayCollection();
  }

  public function __toString() {
    return $this->name;
  }

  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set name
   *
   * @param string $name
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * Get name
   *
   * @return string 
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set role
   *
   * @param string $role
   */
  public function setRole($role) {
    $this->role = $role;
  }

  /**
   * Get role
   *
   * @return strine 
   */
  public function getRole() {
    return $this->role;
  }

  /**
   * Add users
   *
   * @param Oxygen\UserBundle\Entity\User $users
   */
  public function addUser(User $users) {
    $this->users[] = $users;
  }

  /**
   * Get users
   *
   * @return Doctrine\Common\Collections\Collection 
   */
  public function getUsers() {
    return $this->users;
  }

}