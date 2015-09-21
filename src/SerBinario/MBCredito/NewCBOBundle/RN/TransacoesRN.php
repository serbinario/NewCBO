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
    * @param type $estado
    * @param type $dateIni
    * @param type $dateFin
    * @return type
    */
    public function findByOperadoresByEstadoBetweenDateBruto($estado, $dateIni = "", $dateFin = "")
    {
        $result = $this->dao->findByOperadoresByEstadoBetweenDateBruto($estado, $dateIni, $dateFin);
        
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
    * @param type $estado
    * @param type $dateIni
    * @param type $dateFin
    * @return type
    */
    public function findByOperadoresByEstadoBetweenDateLiquido($estado, $dateIni = "", $dateFin = "")
    {
        $result = $this->dao->findByOperadoresByEstadoBetweenDateLiquido($estado, $dateIni, $dateFin);
        
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
    * @param type $estado
    * @param type $dateIni
    * @param type $dateFin
    * @return type
    */
    public function findByOperadoresByEstadoBetweenDateTrocoLiquido($estado, $dateIni = "", $dateFin = "")
    {
        $result = $this->dao->findByOperadoresByEstadoBetweenDateTrocoLiquido($estado, $dateIni, $dateFin);
        
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
    
    /**
     * 
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findTotalDateBruto($dateIni = "", $dateFin = "")
    {
        $result = $this->dao->findTotalDateBruto($dateIni, $dateFin);
        
        return $result;
    }
    
    /**
     * 
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findTotalDateLiquido($dateIni = "", $dateFin = "")
    {
        $result = $this->dao->findTotalDateLiquido($dateIni, $dateFin);
        
        return $result;
    }
    
     /**
     * 
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findTotalnDateTrocoLiquido($dateIni = "", $dateFin = "")
    {
        $result = $this->dao->findTotalnDateTrocoLiquido($dateIni, $dateFin);
        
        return $result;
    }
}
