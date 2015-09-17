<?php

namespace SerBinario\MBCredito\NewCBOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes;

/**
 * ArquivoCabecalho
 *
 * @ORM\Table(name="arquivo_cabecalho")
 * @ORM\Entity
 */
class ArquivoCabecalho
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_arquivo_cabecalho", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArquivoCabecalho;

    /**
     * @var string
     *
     * @ORM\Column(name="banco_arquivo_cabecalho", type="string", length=5, nullable=false)
     */
    private $bancoArquivoCabecalho;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_arquivo_cabecalho", type="date", nullable=false)
     */
    private $dataArquivoCabecalho;

    /**
     * @var string
     *
     * @ORM\Column(name="nome_arquivo_cabecalho", type="string", length=10, nullable=false)
     */
    private $nomeArquivoCabecalho;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_remessa_arquivo_cabecalho", type="string", length=10, nullable=false)
     */
    private $codRemessaArquivoCabecalho;

    /**
     * @var string
     *
     * @ORM\Column(name="seq_correspondente_arquivo_cabecalho", type="string", length=10, nullable=false)
     */
    private $seqCorrespondenteArquivoCabecalho;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_mci_correspondente_arquivo_cabecalho", type="string", length=10, nullable=false)
     */
    private $codMciCorrespondenteArquivoCabecalho;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Transacoes", mappedBy="arquivoCabecalhoArquivoCabecalho")
     */
    private $transacoes;
    
    
    /**
     * @var ArquivoCBF
     * @ORM\OneToOne(targetEntity="ArquivoCBF")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="arquivocbf_id_arquivocbf", referencedColumnName="id")
     * })
     */
    private $arquivoCBF;
    
    /**
     * 
     */
    public function __construct() 
    {
       $this->transacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }



    /**
     * Get idArquivoCabecalho
     *
     * @return integer 
     */
    public function getIdArquivoCabecalho()
    {
        return $this->idArquivoCabecalho;
    }

    /**
     * Set bancoArquivoCabecalho
     *
     * @param string $bancoArquivoCabecalho
     * @return ArquivoCabecalho
     */
    public function setBancoArquivoCabecalho($bancoArquivoCabecalho)
    {
        $this->bancoArquivoCabecalho = $bancoArquivoCabecalho;

        return $this;
    }

    /**
     * Get bancoArquivoCabecalho
     *
     * @return string 
     */
    public function getBancoArquivoCabecalho()
    {
        return $this->bancoArquivoCabecalho;
    }

    /**
     * Set dataArquivoCabecalho
     *
     * @param \DateTime $dataArquivoCabecalho
     * @return ArquivoCabecalho
     */
    public function setDataArquivoCabecalho($dataArquivoCabecalho)
    {
        $this->dataArquivoCabecalho = $dataArquivoCabecalho;

        return $this;
    }

    /**
     * Get dataArquivoCabecalho
     *
     * @return \DateTime 
     */
    public function getDataArquivoCabecalho()
    {
        return $this->dataArquivoCabecalho;
    }

    /**
     * Set nomeArquivoCabecalho
     *
     * @param string $nomeArquivoCabecalho
     * @return ArquivoCabecalho
     */
    public function setNomeArquivoCabecalho($nomeArquivoCabecalho)
    {
        $this->nomeArquivoCabecalho = $nomeArquivoCabecalho;

        return $this;
    }

    /**
     * Get nomeArquivoCabecalho
     *
     * @return string 
     */
    public function getNomeArquivoCabecalho()
    {
        return $this->nomeArquivoCabecalho;
    }

    /**
     * Set codRemessaArquivoCabecalho
     *
     * @param string $codRemessaArquivoCabecalho
     * @return ArquivoCabecalho
     */
    public function setCodRemessaArquivoCabecalho($codRemessaArquivoCabecalho)
    {
        $this->codRemessaArquivoCabecalho = $codRemessaArquivoCabecalho;

        return $this;
    }

    /**
     * Get codRemessaArquivoCabecalho
     *
     * @return string 
     */
    public function getCodRemessaArquivoCabecalho()
    {
        return $this->codRemessaArquivoCabecalho;
    }

    /**
     * Set seqCorrespondenteArquivoCabecalho
     *
     * @param string $seqCorrespondenteArquivoCabecalho
     * @return ArquivoCabecalho
     */
    public function setSeqCorrespondenteArquivoCabecalho($seqCorrespondenteArquivoCabecalho)
    {
        $this->seqCorrespondenteArquivoCabecalho = $seqCorrespondenteArquivoCabecalho;

        return $this;
    }

    /**
     * Get seqCorrespondenteArquivoCabecalho
     *
     * @return string 
     */
    public function getSeqCorrespondenteArquivoCabecalho()
    {
        return $this->seqCorrespondenteArquivoCabecalho;
    }

    /**
     * Set codMciCorrespondenteArquivoCabecalho
     *
     * @param string $codMciCorrespondenteArquivoCabecalho
     * @return ArquivoCabecalho
     */
    public function setCodMciCorrespondenteArquivoCabecalho($codMciCorrespondenteArquivoCabecalho)
    {
        $this->codMciCorrespondenteArquivoCabecalho = $codMciCorrespondenteArquivoCabecalho;

        return $this;
    }

    /**
     * Get codMciCorrespondenteArquivoCabecalho
     *
     * @return string 
     */
    public function getCodMciCorrespondenteArquivoCabecalho()
    {
        return $this->codMciCorrespondenteArquivoCabecalho;
    }
    
    
    /**
     * Add $trasacoes
     *
     * @param string $trasacoes
     * @return ArquivoCabecalho
     */
    public function addTransacoes(Transacoes $trasacoes)
    {   
        $trasacoes->setArquivoCabecalhoArquivoCabecalho($this);
        
        $this->transacoes[] = $trasacoes;
        
        return $this;
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
     * Set transacoes
     *
     * @param  $transacoes
     * @return ArquivoCabecalho
     */
    public function setTransacoes($transacoes) 
    {
        $this->transacoes = $transacoes;
        
        return $this;
    }

    
    /**
     * 
     * @return type
     */
    public function getArquivoCBF() 
    {
        return $this->arquivoCBF;
    }
    
    /**
     * 
     * @param type $arquivoCBF
     */
    public function setArquivoCBF($arquivoCBF) 
    {
        $this->arquivoCBF = $arquivoCBF;
    }



}
