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
     *
     * @var @ORM\Column(name="status_operadores", type="boolean", nullable=true)
     */
    private $statusOperadores = true;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Transacoes", mappedBy="operadoresOperadores")
     */
    private $transacoes;



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
    
    /**
     * Get transacoes
     *
     * @return  \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTransacoes() 
    {
        return $this->transacoes;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->transacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set statusOperadores
     *
     * @param boolean $statusOperadores
     * @return Operadores
     */
    public function setStatusOperadores($statusOperadores)
    {
        $this->statusOperadores = $statusOperadores;

        return $this;
    }

    /**
     * Get statusOperadores
     *
     * @return boolean 
     */
    public function getStatusOperadores()
    {
        return $this->statusOperadores;
    }

    /**
     * Add transacoes
     *
     * @param \SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes $transacoes
     * @return Operadores
     */
    public function addTransaco(\SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes $transacoes)
    {
        $this->transacoes[] = $transacoes;

        return $this;
    }

    /**
     * Remove transacoes
     *
     * @param \SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes $transacoes
     */
    public function removeTransaco(\SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes $transacoes)
    {
        $this->transacoes->removeElement($transacoes);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNomeOperadores() . "";
    }
}
