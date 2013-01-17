<?php

namespace Oxygen\UserBundle\Entity;

use \Symfony\Component\Security\Core\User\UserInterface;
use \Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Oxygen\UserBundle\Entity\Role;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Oxygen\UserBundle\Entity\User
 *
 * @ORM\MappedSuperclass
 * @UniqueEntity(fields="email", message="The email you entered already has an account")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements AdvancedUserInterface, \Serializable
{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $username
     * @Assert\NotBlank()
     * @ORM\Column(name="username", type="string", length=255)
     */
    protected $username;

    /**
     * @var string $salt
     * 
     * @ORM\Column(name="salt", type="string", length=40)
     */
    protected $salt;

    /**
     * @var string $password
     * @Assert\NotNull(message="You must enter a password")
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @var string $active
     * @ORM\Column(name="active", type="boolean")
     */
    protected $active;

    /**
     * @var string $token
     * @ORM\Column(name="token", type="string", length=255)
     */
    protected $token;

    /**
     * @var string $email
     * @Assert\Email(message="You must provide a valid email address")
     * @Assert\NotNull(message="You must provide a valid email address")
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    protected $email;

    /**
     * @ORM\ManyToMany(targetEntity="Oxygen\UserBundle\Entity\Role", inversedBy="users")
     */
    protected $roles;
    protected $delete_form;

    /**
     * @ORM\Column(name="created", type="datetime");
     */
    protected $created;

    /**
     * @ORM\Column(name="updated", type="datetime");
     */
    protected $updated;

    public function __construct()
    {
        $this->salt = $this->random();
        $this->token = $this->random();
        $this->roles = new ArrayCollection();
    }

    public function random()
    {
        return base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set active
     *
     * @param integer $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->active;
    }

    public function eraseCredentials()
    {
        
    }

    public function equals(UserInterface $user)
    {
        return $this->username === $user->getUsername() || $this->email === $user->getEmail();
    }

    public function getRoles()
    {
        $backtrace = debug_backtrace();
        if (isset($backtrace[2], $backtrace[2]['class'])
            && in_array(
                $backtrace[2]['class'],
                array(
                     "Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager",
                     "Symfony\Component\Security\Http\RememberMe\AbstractRememberMeServices",
                     "Symfony\Component\Security\Core\Authentication\Provider\RememberMeAuthenticationProvider"
                )
            )
        ) {
            return $this->roles->toArray();
        }

        return $this->roles;
    }

    public function getRoleObjects()
    {
        return $this->roles;
    }

    /**
     * Add roles
     *
     * @param Oxygen\UserBundle\Entity\Role $role
     */
    public function addRole(Role $role)
    {
        $this->roles[] = $role;
    }

    /**
     * Set roles
     *
     * @param Array(Oxygen\UserBundle\Entity\Role) $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function setDeleteForm($form)
    {
        $this->delete_form = $form;
    }

    public function getDeleteForm()
    {
        return $this->delete_form;
    }

    public function createFormBuilder($data = null, array $options = array())
    {
        return $this->container->get('form.factory')->createBuilder('form', $data, $options);
    }

    /**
     * Set token
     *
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * 
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @ORM\preUpdate
     */
    public function updateUser()
    {
        $this->setToken($this->random());
        $this->setUpdated(new \DateTime());
    }

    /**
     * @ORM\prePersist
     */
    public function setTimestamps()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return datetime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    public function serialize()
    {
        return serialize(array(
                $this->id,
                $this->password,
                $this->username,
                $this->roles
            ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->password,
            $this->username,
            $this->roles
            ) = unserialize($serialized);
    }

}