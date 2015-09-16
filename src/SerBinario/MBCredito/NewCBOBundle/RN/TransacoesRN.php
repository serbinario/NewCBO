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
    public function findByCodTransacao($codigo, $data = array(), $operador = "")
    {
        $result = $this->dao->findByCodTransacao($codigo);
        
        return $result;
    }
    
    /**
     * 
     * @param type $idOperador
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findByOperadorBetweenDateBruto($idOperador, $dateIni = "", $dateFin = "")
    {
        $result = $this->dao->findByOperadorBetweenDateBruto($idOperador, $dateIni, $dateFin);
        
        return $result;
    }  
    
     /**
     * 
     * @param type $idOperador
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findByOperadorBetweenDateLiquido($idOperador, $dateIni = "", $dateFin = "")
    {
        $result = $this->dao->findByOperadorBetweenDateLiquido($idOperador, $dateIni, $dateFin);
        
        return $result;
    }  
    
    /**
     * 
     * @param type $idOperador
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findByOperadorBetweenDateTrocoLiquido($idOperador, $dateIni = "", $dateFin = "")
    {
        $result = $this->dao->findByOperadorBetweenDateTrocoLiquido($idOperador, $dateIni, $dateFin);
        
        return $result;
    }  
    
     /**
     * 
     * @param type $idOperador
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findByOperadorBetweenDateCancelado($idOperador, $dateIni = "", $dateFin = "")
    {
        $result = $this->dao->findByOperadorBetweenDateCancelado($idOperador, $dateIni, $dateFin);
        
        return $result;
    } 
    
    /**
     * 
     * @param type $idOperador
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findByOperadorBetweenDateTrocoCancelado($idOperador, $dateIni = "", $dateFin = "")
    {
        $result = $this->dao->findByOperadorBetweenDateTrocoCancelado($idOperador, $dateIni, $dateFin);
        
        return $result;
    }
}
