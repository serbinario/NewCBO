<?php
namespace SerBinario\MBCredito\CallCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tipo_contrato")
 * @ORM\Entity
 */
class TipoContrato 
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
     * @ORM\Column(name="tipo_contrato", type="string", nullable=true)
     */
    private $tipoContrato;

    /**
     * Set id
     *
     * @param integer $id
     * @return TipoContrato
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
     * Set tipoContrato
     *
     * @param string $tipoContrato
     * @return TipoContrato
     */
    public function setTipoContrato($tipoContrato)
    {
        $this->tipoContrato = $tipoContrato;

        return $this;
    }

    /**
     * Get tipoContrato
     *
     * @return string 
     */
    public function getTipoContrato()
    {
        return $this->tipoContrato;
    }
    
    /**
     * 
     * @return type
     */
    public function __toString() 
    {
        return $this->getTipoContrato();
    }
}
