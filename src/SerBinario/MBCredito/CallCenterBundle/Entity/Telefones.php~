<?php
namespace SerBinario\MBCredito\CallCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="telefones")
 * @ORM\Entity
 */
class Telefones 
{
    /**
     *
     * @var integer
     * 
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id; 
    
    /**
     *
     * @var string
     * 
     * @ORM\Column(name="telefone", type="string", nullable=true)
     */
    private $telefone;
    
    /**
     * @var SerBinario\MBCredito\CallCenterBundle\Entity\Clientes
     * 
     * @ORM\ManyToOne(targetEntity="Clientes", inversedBy="telefones")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     **/
    private $cliente;

    /**
     * Set id
     *
     * @param integer $id
     * @return Telefones
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set telefone
     *
     * @param string $telefone
     * @return Telefones
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get telefone
     *
     * @return string 
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set cliente
     *
     * @param \SerBinario\MBCredito\CallCenterBundle\Entity\Clientes $cliente
     * @return Telefones
     */
    public function setCliente(\SerBinario\MBCredito\CallCenterBundle\Entity\Clientes $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \SerBinario\MBCredito\CallCenterBundle\Entity\Clientes 
     */
    public function getCliente()
    {
        return $this->cliente;
    }
}
