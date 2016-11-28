<?php
namespace SerBinario\MBCredito\NewCBOBundle\RN;

use SerBinario\MBCredito\NewCBOBundle\DAO\TransacoesDAO;

/**
 * Description of TransacoesRN
 *
 * @author serbinario
 */
class TransacoesRN 
{
    /**
     *
     * @var type 
     */
    private $dao;
    
    /**
     * 
     * @param ArquivoCBFDAO $dao
     */
    public function __construct(TransacoesDAO $dao)
    {
        $this->dao = $dao;
    }
    
    /**
     * 
     * @param type $codigo
     * @return boolean
     */
    public function findByCodTransacao($codigo, $operador, $data = array())
    {
        $result = $this->dao->findByCodTransacao($codigo, $operador, $data);
        
        return $result;
    }
    
    /**
     * 
     * @param type $codOperacao
     * @return boolean
     */
    public function findByCodOperacao($codOperacao, $codigoTransacao, $data = array())
    {
        $result = $this->dao->findByCodOperacao($codOperacao, $codigoTransacao, $data);
        
        return $result;
    }
}
