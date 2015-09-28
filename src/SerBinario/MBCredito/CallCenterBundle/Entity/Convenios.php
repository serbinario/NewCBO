<?php
namespace SerBinario\MBCredito\CallCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="convenios_callcenter")
 * @ORM\Entity
 */
class Convenios 
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
     * @ORM\Column(name="nome_convenio", type="string", nullable=true)
     */
    private $convenio;

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
     * Set convenio
     *
     * @param string $convenio
     * @return Convenios
     */
    public function setConvenio($convenio)
    {
        $this->convenio = $convenio;

        return $this;
    }

    /**
     * Get convenio
     *
     * @return string 
     */
    public function getConvenio()
    {
        return $this->convenio;
    }
    
    /**
     * 
     * @return type
     */
    public function __toString() 
    {
        return $this->getConvenio();
    }
}
