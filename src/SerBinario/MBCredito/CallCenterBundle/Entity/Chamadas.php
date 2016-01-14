<?php
namespace SerBinario\MBCredito\CallCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="chamadas")
 * @ORM\Entity
 */
class Chamadas
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
     * @ORM\Column(name="prazo", type="integer", nullable=true)
     */
    private $prazo;
    
    /**
     *
     * @var double
     * 
     * @ORM\Column(name="valor_contratado", type="float", nullable=true)
     */
    private $valorContratado;
    
    /**
     *
     * @var \DateTime
     * 
     * @ORM\Column(name="data_contratado", type="datetime", nullable=true)
     */
    private $dataContratado;
    
    /**
     * 
     * @var boolean
     * 
     * @ORM\Column(name="status_chamada", type="boolean", nullable=true)
     */
    private $statusChamada;
    
     /**
     *
     * @var integer
     * 
     * @ORM\Column(name="codigo_transacao", type="string", nullable=true)
     */
    private $codigoTransacao;
    
    /**
     * @var SerBinario\MBCredito\CallCenterBundle\Entity\Clientes
     * 
     * @ORM\ManyToOne(targetEntity="Clientes", inversedBy="chamadas")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     **/
    private $cliente;
    
    /**
     * @var SerBinario\MBCredito\CallCenterBundle\Entity\TipoContrato
     * 
     * @ORM\ManyToOne(targetEntity="TipoContrato")
     * @ORM\JoinColumn(name="tipo_contrato_id", referencedColumnName="id")
     **/
    private $tipoContrato;
    
    /**
     * @var SerBinario\MBCredito\CallCenterBundle\Entity\Convenios
     * 
     * @ORM\ManyToOne(targetEntity="Convenios")
     * @ORM\JoinColumn(name="convenio_id", referencedColumnName="id")
     **/
    private $convenio;    

    /**
     * Set id
     *
     * @param integer $id
     * @return Chamadas
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
     * Set prazo
     *
     * @param integer $prazo
     * @return Chamadas
     */
    public function setPrazo($prazo)
    {
        $this->prazo = $prazo;

        return $this;
    }

    /**
     * Get prazo
     *
     * @return integer 
     */
    public function getPrazo()
    {
        return $this->prazo;
    }
    
    /**
     * Set valorContratado
     *
     * @param string $valorContratado
     * @return Chamadas
     */
    public function setValorContratado($valorContratado)
    {
        $this->valorContratado = $valorContratado;

        return $this;
    }

    /**
     * Get valorContratado
     *
     * @return string 
     */
    public function getValorContratado()
    {
        return $this->valorContratado;
    }

    /**
     * Set dataContratado
     *
     * @param \DateTime $dataContratado
     * @return Chamadas
     */
    public function setDataContratado($dataContratado)
    {
        $this->dataContratado = $dataContratado;

        return $this;
    }

    /**
     * Get dataContratado
     *
     * @return \DateTime 
     */
    public function getDataContratado()
    {
        return $this->dataContratado;
    }

    /**
     * Set statusChamada
     *
     * @param boolean $statusChamada
     * @return Chamadas
     */
    public function setStatusChamada($statusChamada)
    {
        $this->statusChamada = $statusChamada;

        return $this;
    }

    /**
     * Get statusChamada
     *
     * @return boolean 
     */
    public function getStatusChamada()
    {
        return $this->statusChamada;
    }

    /**
     * Set cliente
     *
     * @param \SerBinario\MBCredito\CallCenterBundle\Entity\Clientes $cliente
     * @return Chamadas
     */
    public function setCliente(\SerBinario\MBCredito\CallCenterBundle\Entity\Clientes $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \SerBinario\MBCredito\CallCenterBundle\Entity\Clientes 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set tipoContrato
     *
     * @param \SerBinario\MBCredito\CallCenterBundle\Entity\TipoContrato $tipoContrato
     * @return Chamadas
     */
    public function setTipoContrato(\SerBinario\MBCredito\CallCenterBundle\Entity\TipoContrato $tipoContrato = null)
    {
        $this->tipoContrato = $tipoContrato;

        return $this;
    }

    /**
     * Get tipoContrato
     *
     * @return \SerBinario\MBCredito\CallCenterBundle\Entity\TipoContrato 
     */
    public function getTipoContrato()
    {
        return $this->tipoContrato;
    }

    /**
     * Set convenio
     *
     * @param \SerBinario\MBCredito\CallCenterBundle\Entity\Convenios $convenio
     * @return Chamadas
     */
    public function setConvenio(\SerBinario\MBCredito\CallCenterBundle\Entity\Convenios $convenio = null)
    {
        $this->convenio = $convenio;

        return $this;
    }

    /**
     * Get convenio
     *
     * @return \SerBinario\MBCredito\CallCenterBundle\Entity\Convenios 
     */
    public function getConvenio()
    {
        return $this->convenio;
    }
    
    /**
     * 
     * @return type
     */
    public function getCodigoTransacao() 
    {
        return $this->codigoTransacao;
    }
    
    /**
     * 
     * @param type $codigoTransacao
     */
    public function setCodigoTransacao($codigoTransacao) 
    {
        $this->codigoTransacao = $codigoTransacao;
    }
}