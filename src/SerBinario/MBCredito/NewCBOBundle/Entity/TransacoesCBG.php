<?php

namespace SerBinario\MBCredito\NewCBOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TransacoesCBG
 * @package SerBinario\MBCredito\NewCBOBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="transacoes_cbg")
 */
class TransacoesCBG
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
     * @ORM\Column(name="codigo_gestor_rede", length=9, nullable=true)
     */
    private $codigoGestorRede;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_correspondente", type="string", length=9, nullable=true)
     */
    private $codigoCorrespondente;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_loja", type="string", length=9, nullable=true)
     */
    private $codigoLoja;

    /**
     * @var string
     *
     * @ORM\Column(name="agencia", type="string", length=9, nullable=true)
     */
    private $agencia;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_contrato", type="string", length=9, nullable=true)
     */
    private $numeroContrato;

    /**
     * @var string
     *
     * @ORM\Column(name="chave_operador", type="string", length=8, nullable=true)
     */
    private $chaveOperador;

    /**
     * @var decimal
     *
     * @ORM\Column(name="valor_parcela", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valorParcela;

    /**
     * @var \DateTime
     *
     * ORM\Column(name="data_fim", type="date", nullable=true)
     */
    private $dataFim;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_parcela", type="integer", nullable=true)
     */
    private $numeroParcela;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantidade_parcela", type="integer", nullable=true)
     */
    private $quantidadeParcela;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_estado_operacao", type="string", length=4, nullable=true)
     */
    private $codigoEstadoOperacao;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_estado_pagamento", type="string", length=4, nullable=true)
     */
    private $codigoEstadoPagamento;

    /**
     * @var \ArquivoCabecalho
     *
     * @ORM\ManyToOne(targetEntity="ArquivoCabecalhoCBG", inversedBy="transacoesCBG")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="arquivo_cabecalhocbg_id", referencedColumnName="id")
     * })
     */
    private $arquivoCabecalhoCBG;

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
     * Set codigoGestorRede
     *
     * @param string $codigoGestorRede
     * @return TransacoesCBG
     */
    public function setCodigoGestorRede($codigoGestorRede)
    {
        $this->codigoGestorRede = $codigoGestorRede;

        return $this;
    }

    /**
     * Get codigoGestorRede
     *
     * @return string 
     */
    public function getCodigoGestorRede()
    {
        return $this->codigoGestorRede;
    }

    /**
     * Set codigoCorrespondente
     *
     * @param string $codigoCorrespondente
     * @return TransacoesCBG
     */
    public function setCodigoCorrespondente($codigoCorrespondente)
    {
        $this->codigoCorrespondente = $codigoCorrespondente;

        return $this;
    }

    /**
     * Get codigoCorrespondente
     *
     * @return string 
     */
    public function getCodigoCorrespondente()
    {
        return $this->codigoCorrespondente;
    }

    /**
     * Set codigoLoja
     *
     * @param string $codigoLoja
     * @return TransacoesCBG
     */
    public function setCodigoLoja($codigoLoja)
    {
        $this->codigoLoja = $codigoLoja;

        return $this;
    }

    /**
     * Get codigoLoja
     *
     * @return string 
     */
    public function getCodigoLoja()
    {
        return $this->codigoLoja;
    }

    /**
     * Set agencia
     *
     * @param string $agencia
     * @return TransacoesCBG
     */
    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;

        return $this;
    }

    /**
     * Get agencia
     *
     * @return string 
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * Set numeroContrato
     *
     * @param string $numeroContrato
     * @return TransacoesCBG
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
     * Set chaveOperador
     *
     * @param string $chaveOperador
     * @return TransacoesCBG
     */
    public function setChaveOperador($chaveOperador)
    {
        $this->chaveOperador = $chaveOperador;

        return $this;
    }

    /**
     * Get chaveOperador
     *
     * @return string 
     */
    public function getChaveOperador()
    {
        return $this->chaveOperador;
    }

    /**
     * Set valorParcela
     *
     * @param string $valorParcela
     * @return TransacoesCBG
     */
    public function setValorParcela($valorParcela)
    {
        $this->valorParcela = $valorParcela;

        return $this;
    }

    /**
     * Get valorParcela
     *
     * @return string 
     */
    public function getValorParcela()
    {
        return $this->valorParcela;
    }

    /**
     * Set numeroParcela
     *
     * @param integer $numeroParcela
     * @return TransacoesCBG
     */
    public function setNumeroParcela($numeroParcela)
    {
        $this->numeroParcela = $numeroParcela;

        return $this;
    }

    /**
     * Get numeroParcela
     *
     * @return integer 
     */
    public function getNumeroParcela()
    {
        return $this->numeroParcela;
    }

    /**
     * Set quantidadeParcela
     *
     * @param integer $quantidadeParcela
     * @return TransacoesCBG
     */
    public function setQuantidadeParcela($quantidadeParcela)
    {
        $this->quantidadeParcela = $quantidadeParcela;

        return $this;
    }

    /**
     * Get quantidadeParcela
     *
     * @return integer 
     */
    public function getQuantidadeParcela()
    {
        return $this->quantidadeParcela;
    }

    /**
     * Set codigoEstadoOperacao
     *
     * @param string $codigoEstadoOperacao
     * @return TransacoesCBG
     */
    public function setCodigoEstadoOperacao($codigoEstadoOperacao)
    {
        $this->codigoEstadoOperacao = $codigoEstadoOperacao;

        return $this;
    }

    /**
     * Get codigoEstadoOperacao
     *
     * @return string 
     */
    public function getCodigoEstadoOperacao()
    {
        return $this->codigoEstadoOperacao;
    }

    /**
     * Set codigoEstadoPagamento
     *
     * @param string $codigoEstadoPagamento
     * @return TransacoesCBG
     */
    public function setCodigoEstadoPagamento($codigoEstadoPagamento)
    {
        $this->codigoEstadoPagamento = $codigoEstadoPagamento;

        return $this;
    }

    /**
     * Get codigoEstadoPagamento
     *
     * @return string 
     */
    public function getCodigoEstadoPagamento()
    {
        return $this->codigoEstadoPagamento;
    }

    /**
     * Set arquivoCabecalhoCBG
     *
     * @param \SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalhoCBG $arquivoCabecalhoCBG
     * @return TransacoesCBG
     */
    public function setArquivoCabecalhoCBG(\SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalhoCBG $arquivoCabecalhoCBG = null)
    {
        $this->arquivoCabecalhoCBG = $arquivoCabecalhoCBG;

        return $this;
    }

    /**
     * Get arquivoCabecalhoCBG
     *
     * @return \SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalhoCBG 
     */
    public function getArquivoCabecalhoCBG()
    {
        return $this->arquivoCabecalhoCBG;
    }
}
