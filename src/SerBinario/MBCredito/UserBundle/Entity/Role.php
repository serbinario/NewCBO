<?php

namespace SerBinario\MBCredito\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="SerBinario\MBCredito\UserBundle\Entity\RoleRepository")
 */
class Role implements RoleInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $role;

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
     * Set role
     *
     * @param string $role
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        # retorno
        return $this->role;
    }

    /**
     *
     */
    public function __toString()
    {
        # Cortando a string
        $explode = explode("_", $this->role);

        # Verificando o explode
        if(count($explode) > 0) {
            # Retorno
            return $explode[1];
        }

        # retorno
        return $this->role;
    }
}
