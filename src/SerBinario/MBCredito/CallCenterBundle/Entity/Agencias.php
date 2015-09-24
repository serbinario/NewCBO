<?php
namespace SerBinario\MBCredito\CallCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="agencias_callcenter")
 * @ORM\Entity
 */
class Agencias
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
     * @var integer
     * 
     * @ORM\Column(name="numero_agencia", type="integer", nullable=true)
     */
    private $numeroAgencia;    
    
    /**
     *
     * @var string
     * 
     * @ORM\Column(name="nome_agencia", type="string", nullable=true)
     */
    private $nomeAgencia;

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
     * Set numeroAgencia
     *
     * @param integer $numeroAgencia
     * @return Agencias
     */
    public function setNumeroAgencia($numeroAgencia)
    {
        $this->numeroAgencia = $numeroAgencia;

        return $this;
    }

    /**
     * Get numeroAgencia
     *
     * @return integer 
     */
    public function getNumeroAgencia()
    {
        return $this->numeroAgencia;
    }

    /**
     * Set nomeAgencia
     *
     * @param string $nomeAgencia
     * @return Agencias
     */
    public function setNomeAgencia($nomeAgencia)
    {
        $this->nomeAgencia = $nomeAgencia;

        return $this;
    }

    /**
     * Get nomeAgencia
     *
     * @return string 
     */
    public function getNomeAgencia()
    {
        return $this->nomeAgencia;
    }
    
    /**
     * 
     * @return type
     */
    public function __toString() 
    {
       return $this->getNumeroAgencia() . " : " . $this->getNomeAgencia();
    }
}
