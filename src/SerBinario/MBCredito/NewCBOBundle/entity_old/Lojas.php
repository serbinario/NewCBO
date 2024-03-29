<?php

namespace SerBinario\MBCredito\NewCBOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lojas
 *
 * @ORM\Table(name="lojas")
 * @ORM\Entity
 */
class Lojas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_lojas", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLojas;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_lojas", type="string", length=5, nullable=false)
     */
    private $codigoLojas;

    /**
     * @var string
     *
     * @ORM\Column(name="uf_lojas", type="string", length=5, nullable=true)
     */
    private $ufLojas;



    /**
     * Get idLojas
     *
     * @return integer 
     */
    public function getIdLojas()
    {
        return $this->idLojas;
    }

    /**
     * Set codigoLojas
     *
     * @param string $codigoLojas
     * @return Lojas
     */
    public function setCodigoLojas($codigoLojas)
    {
        $this->codigoLojas = $codigoLojas;

        return $this;
    }

    /**
     * Get codigoLojas
     *
     * @return string 
     */
    public function getCodigoLojas()
    {
        return $this->codigoLojas;
    }

    /**
     * Set ufLojas
     *
     * @param string $ufLojas
     * @return Lojas
     */
    public function setUfLojas($ufLojas)
    {
        $this->ufLojas = $ufLojas;

        return $this;
    }

    /**
     * Get ufLojas
     *
     * @return string 
     */
    public function getUfLojas()
    {
        return $this->ufLojas;
    }
}
