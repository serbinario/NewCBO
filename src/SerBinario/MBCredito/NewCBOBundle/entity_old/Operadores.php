<?php

namespace SerBinario\MBCredito\NewCBOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Operadores
 *
 * @ORM\Table(name="operadores")
 * @ORM\Entity
 */
class Operadores
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_operadores", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOperadores;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_operadores", type="string", length=20, nullable=false)
     */
    private $codOperadores;

    /**
     * @var string
     *
     * @ORM\Column(name="nome_operadores", type="string", length=50, nullable=true)
     */
    private $nomeOperadores;



    /**
     * Get idOperadores
     *
     * @return integer 
     */
    public function getIdOperadores()
    {
        return $this->idOperadores;
    }

    /**
     * Set codOperadores
     *
     * @param string $codOperadores
     * @return Operadores
     */
    public function setCodOperadores($codOperadores)
    {
        $this->codOperadores = $codOperadores;

        return $this;
    }

    /**
     * Get codOperadores
     *
     * @return string 
     */
    public function getCodOperadores()
    {
        return $this->codOperadores;
    }

    /**
     * Set nomeOperadores
     *
     * @param string $nomeOperadores
     * @return Operadores
     */
    public function setNomeOperadores($nomeOperadores)
    {
        $this->nomeOperadores = $nomeOperadores;

        return $this;
    }

    /**
     * Get nomeOperadores
     *
     * @return string 
     */
    public function getNomeOperadores()
    {
        return $this->nomeOperadores;
    }
}
