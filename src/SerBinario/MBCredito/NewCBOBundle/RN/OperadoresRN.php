<?php
namespace SerBinario\MBCredito\NewCBOBundle\RN;

use SerBinario\MBCredito\NewCBOBundle\DAO\OperadoresDAO;
use SerBinario\MBCredito\NewCBOBundle\Entity\Operadores;
/**
 * Description of OperadoresRN
 *
 * @author andrey
 */
class OperadoresRN 
{
    /**
     *
     * @var type 
     */
    private $operadoresDAO;
    
    /**
     * 
     * @param OperadoresDAO $operadoresDAO
     */
    public function __construct(OperadoresDAO $operadoresDAO) 
    {
        $this->operadoresDAO = $operadoresDAO;
    }
    
    /**
     * 
     * @param Operadores $operadores
     * @return type
     */
    public function save(Operadores $operadores)
    {
        $result = $this->operadoresDAO->save($operadores);
        
        return $result;
    }
    
    /**
     * 
     * @param Operadores $operadores
     * @return type
     */
    public function update(Operadores $operadores)
    {
        $result = $this->operadoresDAO->update($operadores);
        
        return $result;
    }
    
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function find($id)
    {
        $result = $this->operadoresDAO->find($id);
        
        return $result;
    }
}
