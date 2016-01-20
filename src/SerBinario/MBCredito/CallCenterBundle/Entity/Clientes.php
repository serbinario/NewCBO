<?php
namespace SerBinario\MBCredito\CallCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="clientes")
 * @ORM\Entity
 */
class Clientes 
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
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    private $nome;
    
    /**
     *
     * @var string
     * 
     * @ORM\Column(name="cpf", type="string", nullable=true)
     */
    private $cpf;
    
    /**
     *
     * @var string
     * 
     * @ORM\Column(name="conta", type="string", nullable=true)
     */
    private $conta; 
    
    /**
     * @var SerBinario\MBCredito\CallCenterBundle\Entity\Chamadas
     * 
     * @ORM\OneToMany(targetEntity="Chamadas", mappedBy="cliente", cascade={"all"})
     **/
    private $chamadas;
    
     /**
     * @var SerBinario\MBCredito\CallCenterBundle\Entity\Chamadas
     * 
     * @ORM\OneToMany(targetEntity="Telefones", mappedBy="cliente", cascade={"all"})
     **/
    private $telefones;
    
    /**
     * @var SerBinario\MBCredito\CallCenterBundle\Entity\Agencias
     * 
     * @ORM\ManyToOne(targetEntity="Agencias")
     * @ORM\JoinColumn(name="agencia_id", referencedColumnName="id")
     **/
    private $agencia;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->chamadas  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->telefones = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Clientes
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
     * Set nome
     *
     * @param string $nome
     * @return Clientes
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set cpf
     *
     * @param integer $cpf
     * @return Clientes
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get cpf
     *
     * @return integer 
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Add chamadas
     *
     * @param \SerBinario\MBCredito\CallCenterBundle\Entity\Chamadas $chamadas
     * @return Clientes
     */
    public function addChamada(\SerBinario\MBCredito\CallCenterBundle\Entity\Chamadas $chamadas)
    {
        $chamadas->setCliente($this);
        
        $this->chamadas[] = $chamadas;

        return $this;
    }

    /**
     * Remove chamadas
     *
     * @param \SerBinario\MBCredito\CallCenterBundle\Entity\Chamadas $chamadas
     */
    public function removeChamada(\SerBinario\MBCredito\CallCenterBundle\Entity\Chamadas $chamadas)
    {
        $this->chamadas->removeElement($chamadas);
    }

    /**
     * Get chamadas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChamadas()
    {
        return $this->chamadas;
    }
        
    /**
     * Set conta
     *
     * @param integer $conta
     * @return Clientes
     */
    public function setConta($conta)
    {
        $this->conta = $conta;

        return $this;
    }

    /**
     * Get conta
     *
     * @return integer 
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * Add telefones
     *
     * @param \SerBinario\MBCredito\CallCenterBundle\Entity\Telefones $telefones
     * @return Clientes
     */
    public function addTelefone(\SerBinario\MBCredito\CallCenterBundle\Entity\Telefones $telefones)
    {
        $telefones->setCliente($this);
        
        $this->telefones[] = $telefones;

        return $this;
    }

    /**
     * Remove telefones
     *
     * @param \SerBinario\MBCredito\CallCenterBundle\Entity\Telefones $telefones
     */
    public function removeTelefone(\SerBinario\MBCredito\CallCenterBundle\Entity\Telefones $telefones)
    {
        $this->telefones->removeElement($telefones);
    }

    /**
     * Get telefones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTelefones()
    {
        return $this->telefones;
    }
    
    /**
     * 
     * @param type $chamadas
     */
    public function setChamadas($chamadas) 
    {           
        $this->chamadas = $chamadas;
    }

    /**
     * 
     * @param type $telefones
     */
    public function setTelefones($telefones) 
    {           
        $this->telefones = $telefones;
    }



    /**
     * Set agencia
     *
     * @param \SerBinario\MBCredito\CallCenterBundle\Entity\Agencias $agencia
     * @return Clientes
     */
    public function setAgencia(\SerBinario\MBCredito\CallCenterBundle\Entity\Agencias $agencia = null)
    {
        $this->agencia = $agencia;

        return $this;
    }

    /**
     * Get agencia
     *
     * @return \SerBinario\MBCredito\CallCenterBundle\Entity\Agencias 
     */
    public function getAgencia()
    {
        return $this->agencia;
    }
}
