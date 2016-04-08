<?php

namespace SerBinario\MBCredito\NewCBOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transacoes
 *
 * @ORM\Table(name="transacoes", indexes={@ORM\Index(name="fk_transacoes_operadores_idx", columns={"operadores_id_operadores"}), @ORM\Index(name="fk_transacoes_arquivo_cabecalho1_idx", columns={"arquivo_cabecalho_id_arquivo_cabecalho"}), @ORM\Index(name="fk_transacoes_transacoes1_idx", columns={"transacoes_id_transacoes"}), @ORM\Index(name="fk_transacoes_lojas1_idx", columns={"lojas_id_lojas"})})
 * @ORM\Entity
 */
class Transacoes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_transacoes", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="banco_transacoes", type="string", length=5, nullable=true)
     */
    private $bancoTransacoes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_transacoes", type="date", nullable=true)
     */
    private $dataTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_agencia_rel_transacoes", type="string", length=5, nullable=true)
     */
    private $codAgenciaRelTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_sequencia_op_transacoes", type="string", length=5, nullable=true)
     */
    private $codSequenciaOpTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_transacoes", type="string", length=5, nullable=true)
     */
    private $codTransacoes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_movimento_transacoes", type="date", nullable=true)
     */
    private $dataMovimentoTransacoes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_transacoes", type="time", nullable=true)
     */
    private $horaTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_transacoes", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valorTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_pdv_transacoes", type="string", length=5, nullable=true)
     */
    private $codPdvTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="forma_liq_transacoes", type="string", length=5, nullable=true)
     */
    private $formaLiqTransacoes;
    
    /**
     * @var string
     *
     * @ORM\Column(name="situacao_doc_transacoes", type="string", length=5, nullable=true)
     */
    private $situacaoDocTransacoes;
    
    /**
     * @var string
     *
     * @ORM\Column(name="retorno_corres_transacoes", type="string", length=10, nullable=true)
     */
    private $retornoCorresTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_linha_transacoes", type="string", length=5, nullable=true)
     */
    private $codLinhaTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_convenio_transacoes", type="string", length=10, nullable=true)
     */
    private $numeroConvenioTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_proposta_transacoes", type="string", length=10, nullable=true)
     */
    private $numeroPropostaTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_liberacao_transacoes", type="string", length=5, nullable=true)
     */
    private $tipoLiberacaoTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="qtd_parcelas_transacoes", type="string", length=5, nullable=true)
     */
    private $qtdParcelasTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_prop_vinculada_transacoes", type="string", length=10, nullable=true)
     */
    private $numeroPropVinculadaTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_troco_transacoes", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valorTrocoTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="custo_convenio_transacoes", type="string", length=5, nullable=true)
     */
    private $custoConvenioTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="seguimento_convenio_transacoes", type="string", length=5, nullable=true)
     */
    private $seguimentoConvenioTransacoes;

    /**
     * @var string
     *
     * @ORM\Column(name="taxa_mensal_transacoes", type="string", length=5, nullable=true)
     */
    private $taxaMensalTransacoes;

    /**
     * @var \Operadores
     *
     * @ORM\ManyToOne(targetEntity="Operadores")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="operadores_id_operadores", referencedColumnName="id_operadores")
     * })
     */
    private $operadoresOperadores;

    /**
     * @var \ArquivoCabecalho
     *
     * @ORM\ManyToOne(targetEntity="ArquivoCabecalho", inversedBy="transacoes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="arquivo_cabecalho_id_arquivo_cabecalho", referencedColumnName="id_arquivo_cabecalho")
     * })
     */
    private $arquivoCabecalhoArquivoCabecalho;

    /**
     * @var \Transacoes
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Transacoes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transacoes_id_transacoes", referencedColumnName="id_transacoes")
     * })
     */
    private $transacoesTransacoes;

    /**
     * @var \Lojas
     *
     * @ORM\ManyToOne(targetEntity="Lojas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lojas_id_lojas", referencedColumnName="id_lojas")
     * })
     */
    private $lojasLojas;



    /**
     * Set idTransacoes
     *
     * @param integer $idTransacoes
     * @return Transacoes
     */
    public function setIdTransacoes($idTransacoes)
    {
        $this->idTransacoes = $idTransacoes;

        return $this;
    }

    /**
     * Get idTransacoes
     *
     * @return integer 
     */
    public function getIdTransacoes()
    {
        return $this->idTransacoes;
    }

    /**
     * Set bancoTransacoes
     *
     * @param string $bancoTransacoes
     * @return Transacoes
     */
    public function setBancoTransacoes($bancoTransacoes)
    {
        $this->bancoTransacoes = $bancoTransacoes;

        return $this;
    }

    /**
     * Get bancoTransacoes
     *
     * @return string 
     */
    public function getBancoTransacoes()
    {
        return $this->bancoTransacoes;
    }

    /**
     * Set dataTransacoes
     *
     * @param \DateTime $dataTransacoes
     * @return Transacoes
     */
    public function setDataTransacoes($dataTransacoes)
    {
        $this->dataTransacoes = $dataTransacoes;

        return $this;
    }

    /**
     * Get dataTransacoes
     *
     * @return \DateTime 
     */
    public function getDataTransacoes()
    {
        return $this->dataTransacoes;
    }

    /**
     * Set codAgenciaRelTransacoes
     *
     * @param string $codAgenciaRelTransacoes
     * @return Transacoes
     */
    public function setCodAgenciaRelTransacoes($codAgenciaRelTransacoes)
    {
        $this->codAgenciaRelTransacoes = $codAgenciaRelTransacoes;

        return $this;
    }

    /**
     * Get codAgenciaRelTransacoes
     *
     * @return string 
     */
    public function getCodAgenciaRelTransacoes()
    {
        return $this->codAgenciaRelTransacoes;
    }

    /**
     * Set codSequenciaOpTransacoes
     *
     * @param string $codSequenciaOpTransacoes
     * @return Transacoes
     */
    public function setCodSequenciaOpTransacoes($codSequenciaOpTransacoes)
    {
        $this->codSequenciaOpTransacoes = $codSequenciaOpTransacoes;

        return $this;
    }

    /**
     * Get codSequenciaOpTransacoes
     *
     * @return string 
     */
    public function getCodSequenciaOpTransacoes()
    {
        return $this->codSequenciaOpTransacoes;
    }

    /**
     * Set codTransacoes
     *
     * @param string $codTransacoes
     * @return Transacoes
     */
    public function setCodTransacoes($codTransacoes)
    {
        $this->codTransacoes = $codTransacoes;

        return $this;
    }

    /**
     * Get codTransacoes
     *
     * @return string 
     */
    public function getCodTransacoes()
    {
        return $this->codTransacoes;
    }

    /**
     * Set dataMovimentoTransacoes
     *
     * @param \DateTime $dataMovimentoTransacoes
     * @return Transacoes
     */
    public function setDataMovimentoTransacoes($dataMovimentoTransacoes)
    {
        $this->dataMovimentoTransacoes = $dataMovimentoTransacoes;

        return $this;
    }

    /**
     * Get dataMovimentoTransacoes
     *
     * @return \DateTime 
     */
    public function getDataMovimentoTransacoes()
    {
        return $this->dataMovimentoTransacoes;
    }

    /**
     * Set horaTransacoes
     *
     * @param \DateTime $horaTransacoes
     * @return Transacoes
     */
    public function setHoraTransacoes($horaTransacoes)
    {
        $this->horaTransacoes = $horaTransacoes;

        return $this;
    }

    /**
     * Get horaTransacoes
     *
     * @return \DateTime 
     */
    public function getHoraTransacoes()
    {
        return $this->horaTransacoes;
    }

    /**
     * Set valorTransacoes
     *
     * @param string $valorTransacoes
     * @return Transacoes
     */
    public function setValorTransacoes($valorTransacoes)
    {
        $this->valorTransacoes = $valorTransacoes;

        return $this;
    }

    /**
     * Get valorTransacoes
     *
     * @return string 
     */
    public function getValorTransacoes()
    {
        return $this->valorTransacoes;
    }

    /**
     * Set codPdvTransacoes
     *
     * @param string $codPdvTransacoes
     * @return Transacoes
     */
    public function setCodPdvTransacoes($codPdvTransacoes)
    {
        $this->codPdvTransacoes = $codPdvTransacoes;

        return $this;
    }

    /**
     * Get codPdvTransacoes
     *
     * @return string 
     */
    public function getCodPdvTransacoes()
    {
        return $this->codPdvTransacoes;
    }

    /**
     * Set formaLiqTransacoes
     *
     * @param string $formaLiqTransacoes
     * @return Transacoes
     */
    public function setFormaLiqTransacoes($formaLiqTransacoes)
    {
        $this->formaLiqTransacoes = $formaLiqTransacoes;

        return $this;
    }

    /**
     * Get formaLiqTransacoes
     *
     * @return string 
     */
    public function getFormaLiqTransacoes()
    {
        return $this->formaLiqTransacoes;
    }
    
    
    /**
     * Get situacaoDocTransacoes
     *
     * @return string 
     */
    public function getSituacaoDocTransacoes() 
    {
        return $this->situacaoDocTransacoes;
    }
    
    
    /**
     * Get retornoCorresTransacoes
     *
     * @return string 
     */
    public function getRetornoCorresTransacoes() 
    {
        return $this->retornoCorresTransacoes;
    }

    
    /**
     * Set situacaoDocTransacoes
     *
     * @param string $situacaoDocTransacoes
     * @return Transacoes
     */
    public function setSituacaoDocTransacoes($situacaoDocTransacoes) 
    {
        $this->situacaoDocTransacoes = $situacaoDocTransacoes;
        
        return $this;
    }

    
    /**
     * Set retornoCorresTransacoes
     *
     * @param string $retornoCorresTransacoes
     * @return Transacoes
     */
    public function setRetornoCorresTransacoes($retornoCorresTransacoes) 
    {
        $this->retornoCorresTransacoes = $retornoCorresTransacoes;
        
        return $this;
    }

    
    /**
     * Set codLinhaTransacoes
     *
     * @param string $codLinhaTransacoes
     * @return Transacoes
     */
    public function setCodLinhaTransacoes($codLinhaTransacoes)
    {
        $this->codLinhaTransacoes = $codLinhaTransacoes;

        return $this;
    }

    /**
     * Get codLinhaTransacoes
     *
     * @return string 
     */
    public function getCodLinhaTransacoes()
    {
        return $this->codLinhaTransacoes;
    }

    /**
     * Set numeroConvenioTransacoes
     *
     * @param string $numeroConvenioTransacoes
     * @return Transacoes
     */
    public function setNumeroConvenioTransacoes($numeroConvenioTransacoes)
    {
        $this->numeroConvenioTransacoes = $numeroConvenioTransacoes;

        return $this;
    }

    /**
     * Get numeroConvenioTransacoes
     *
     * @return string 
     */
    public function getNumeroConvenioTransacoes()
    {
        return $this->numeroConvenioTransacoes;
    }

    /**
     * Set numeroPropostaTransacoes
     *
     * @param string $numeroPropostaTransacoes
     * @return Transacoes
     */
    public function setNumeroPropostaTransacoes($numeroPropostaTransacoes)
    {
        $this->numeroPropostaTransacoes = $numeroPropostaTransacoes;

        return $this;
    }

    /**
     * Get numeroPropostaTransacoes
     *
     * @return string 
     */
    public function getNumeroPropostaTransacoes()
    {
        return $this->numeroPropostaTransacoes;
    }

    /**
     * Set tipoLiberacaoTransacoes
     *
     * @param string $tipoLiberacaoTransacoes
     * @return Transacoes
     */
    public function setTipoLiberacaoTransacoes($tipoLiberacaoTransacoes)
    {
        $this->tipoLiberacaoTransacoes = $tipoLiberacaoTransacoes;

        return $this;
    }

    /**
     * Get tipoLiberacaoTransacoes
     *
     * @return string 
     */
    public function getTipoLiberacaoTransacoes()
    {
        return $this->tipoLiberacaoTransacoes;
    }

    /**
     * Set qtdParcelasTransacoes
     *
     * @param string $qtdParcelasTransacoes
     * @return Transacoes
     */
    public function setQtdParcelasTransacoes($qtdParcelasTransacoes)
    {
        $this->qtdParcelasTransacoes = $qtdParcelasTransacoes;

        return $this;
    }

    /**
     * Get qtdParcelasTransacoes
     *
     * @return string 
     */
    public function getQtdParcelasTransacoes()
    {
        return $this->qtdParcelasTransacoes;
    }

    /**
     * Set numeroPropVinculadaTransacoes
     *
     * @param string $numeroPropVinculadaTransacoes
     * @return Transacoes
     */
    public function setNumeroPropVinculadaTransacoes($numeroPropVinculadaTransacoes)
    {
        $this->numeroPropVinculadaTransacoes = $numeroPropVinculadaTransacoes;

        return $this;
    }

    /**
     * Get numeroPropVinculadaTransacoes
     *
     * @return string 
     */
    public function getNumeroPropVinculadaTransacoes()
    {
        return $this->numeroPropVinculadaTransacoes;
    }

    /**
     * Set valorTrocoTransacoes
     *
     * @param string $valorTrocoTransacoes
     * @return Transacoes
     */
    public function setValorTrocoTransacoes($valorTrocoTransacoes)
    {
        $this->valorTrocoTransacoes = $valorTrocoTransacoes;

        return $this;
    }

    /**
     * Get valorTrocoTransacoes
     *
     * @return string 
     */
    public function getValorTrocoTransacoes()
    {
        return $this->valorTrocoTransacoes;
    }

    /**
     * Set custoConvenioTransacoes
     *
     * @param string $custoConvenioTransacoes
     * @return Transacoes
     */
    public function setCustoConvenioTransacoes($custoConvenioTransacoes)
    {
        $this->custoConvenioTransacoes = $custoConvenioTransacoes;

        return $this;
    }

    /**
     * Get custoConvenioTransacoes
     *
     * @return string 
     */
    public function getCustoConvenioTransacoes()
    {
        return $this->custoConvenioTransacoes;
    }

    /**
     * Set seguimentoConvenioTransacoes
     *
     * @param string $seguimentoConvenioTransacoes
     * @return Transacoes
     */
    public function setSeguimentoConvenioTransacoes($seguimentoConvenioTransacoes)
    {
        $this->seguimentoConvenioTransacoes = $seguimentoConvenioTransacoes;

        return $this;
    }

    /**
     * Get seguimentoConvenioTransacoes
     *
     * @return string 
     */
    public function getSeguimentoConvenioTransacoes()
    {
        return $this->seguimentoConvenioTransacoes;
    }

    /**
     * Set taxaMensalTransacoes
     *
     * @param string $taxaMensalTransacoes
     * @return Transacoes
     */
    public function setTaxaMensalTransacoes($taxaMensalTransacoes)
    {
        $this->taxaMensalTransacoes = $taxaMensalTransacoes;

        return $this;
    }

    /**
     * Get taxaMensalTransacoes
     *
     * @return string 
     */
    public function getTaxaMensalTransacoes()
    {
        return $this->taxaMensalTransacoes;
    }

    /**
     * Set operadoresOperadores
     *
     * @param \SerBinario\MBCredito\NewCBOBundle\Entity\Operadores $operadoresOperadores
     * @return Transacoes
     */
    public function setOperadoresOperadores(\SerBinario\MBCredito\NewCBOBundle\Entity\Operadores $operadoresOperadores = null)
    {
        $this->operadoresOperadores = $operadoresOperadores;

        return $this;
    }

    /**
     * Get operadoresOperadores
     *
     * @return \SerBinario\MBCredito\NewCBOBundle\Entity\Operadores 
     */
    public function getOperadoresOperadores()
    {
        return $this->operadoresOperadores;
    }

    /**
     * Set arquivoCabecalhoArquivoCabecalho
     *
     * @param \SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalho $arquivoCabecalhoArquivoCabecalho
     * @return Transacoes
     */
    public function setArquivoCabecalhoArquivoCabecalho(\SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalho $arquivoCabecalhoArquivoCabecalho = null)
    {
        $this->arquivoCabecalhoArquivoCabecalho = $arquivoCabecalhoArquivoCabecalho;

        return $this;
    }

    /**
     * Get arquivoCabecalhoArquivoCabecalho
     *
     * @return \SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalho 
     */
    public function getArquivoCabecalhoArquivoCabecalho()
    {
        return $this->arquivoCabecalhoArquivoCabecalho;
    }

    /**
     * Set transacoesTransacoes
     *
     * @param \SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes $transacoesTransacoes
     * @return Transacoes
     */
    public function setTransacoesTransacoes(\SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes $transacoesTransacoes)
    {
        $this->transacoesTransacoes = $transacoesTransacoes;

        return $this;
    }

    /**
     * Get transacoesTransacoes
     *
     * @return \SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes 
     */
    public function getTransacoesTransacoes()
    {
        return $this->transacoesTransacoes;
    }

    /**
     * Set lojasLojas
     *
     * @param \SerBinario\MBCredito\NewCBOBundle\Entity\Lojas $lojasLojas
     * @return Transacoes
     */
    public function setLojasLojas(\SerBinario\MBCredito\NewCBOBundle\Entity\Lojas $lojasLojas = null)
    {
        $this->lojasLojas = $lojasLojas;

        return $this;
    }

    /**
     * Get lojasLojas
     *
     * @return \SerBinario\MBCredito\NewCBOBundle\Entity\Lojas 
     */
    public function getLojasLojas()
    {
        return $this->lojasLojas;
    }
    
    
}
