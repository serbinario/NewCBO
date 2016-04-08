<?php

namespace SerBinario\MBCredito\NewCBOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CBG
 *
 * @ORM\Table(name="arquivo_cabecalho_cbg")
 * @ORM\Entity
 */
class ArquivoCabecalhoCBG
{
    /**
    * @var integer
    *
    * @ORM\Column(name="id", type="integer", nullable=false)
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="IDENTITY")
    */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="banco", type="string", length=3, nullable=false)
     */
    private $banco;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="date", nullable=false)
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=8, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="sigla", type="string", length=3, nullable=false)
     */
    private $sigla;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_mci", type="string", length=9, nullable=true)
     */
    private $codigoMCI;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_contrato", type="string", length=9, nullable=true)
     */
    private $numeroContrato;

    /**
     * @var ArquivoCBF
     * @ORM\OneToOne(targetEntity="ArquivoCBG", cascade = {"remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="arquivocbg_id", referencedColumnName="id")
     * })
     */
    private $arquivoCBG;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="TransacoesCBG", mappedBy="arquivoCabecalhoCBG", cascade = {"remove"})
     */
    private $transacoesCBG;


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
     * Set banco
     *
     * @param string $banco
     * @return ArquivoCabecalhoCBG
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;

        return $this;
    }

    /**
     * Get banco
     *
     * @return string 
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     * @return ArquivoCabecalhoCBG
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return ArquivoCabecalhoCBG
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
     * Set sigla
     *
     * @param string $sigla
     * @return ArquivoCabecalhoCBG
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;

        return $this;
    }

    /**
     * Get sigla
     *
     * @return string 
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set codigoMCI
     *
     * @param string $codigoMCI
     * @return ArquivoCabecalhoCBG
     */
    public function setCodigoMCI($codigoMCI)
    {
        $this->codigoMCI = $codigoMCI;

        return $this;
    }

    /**
     * Get codigoMCI
     *
     * @return string 
     */
    public function getCodigoMCI()
    {
        return $this->codigoMCI;
    }

    /**
     * Set numeroContrato
     *
     * @param string $numeroContrato
     * @return ArquivoCabecalhoCBG
     */
    public function setNumeroContrato($numeroContrato)
    {
        $this->numeroContrato = $numeroContrato;

        return $this;
    }

    /**
     * Get numeroContrato
     *
     * @return string 
     */
    public function getNumeroContrato()
    {
        return $this->numeroContrato;
    }

    /**
     * Set arquivoCBG
     *
     * @param \SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCBG $arquivoCBG
     * @return ArquivoCabecalhoCBG
     */
    public function setArquivoCBG(\SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCBG $arquivoCBG = null)
    {
        $this->arquivoCBG = $arquivoCBG;

        return $this;
    }

    /**
     * Get arquivoCBG
     *
     * @return \SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCBG 
     */
    public function getArquivoCBG()
    {
        return $this->arquivoCBG;
    }

    /**
     * Add transacoesCBG
     *
     * @param \SerBinario\MBCredito\NewCBOBundle\Entity\TransacoesCBG $transacoesCBG
     * @return ArquivoCabecalhoCBG
     */
    public function addTransacoesCBG(\SerBinario\MBCredito\NewCBOBundle\Entity\TransacoesCBG $transacoesCBG)
    {
        $this->transacoesCBG[] = $transacoesCBG;

        return $this;
    }

    /**
     * Remove transacoesCBG
     *
     * @param \SerBinario\MBCredito\NewCBOBundle\Entity\TransacoesCBG $transacoesCBG
     */
    public function removeTransacoesCBG(\SerBinario\MBCredito\NewCBOBundle\Entity\TransacoesCBG $transacoesCBG)
    {
        $this->transacoesCBG->removeElement($transacoesCBG);
    }

    /**
     * Get transacoesCBG
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTransacoesCBG()
    {
        return $this->transacoesCBG;
    }

    /**
     * @param $transacoesCBG
     */
    public function setTransacoesCBG($transacoesCBG)
    {
        $this->transacoesCBG = $transacoesCBG;
    }
}
