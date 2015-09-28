<?php
namespace SerBinario\MBCredito\CallCenterBundle\RN;

use SerBinario\MBCredito\CallCenterBundle\Entity\Agencias;
use SerBinario\MBCredito\CallCenterBundle\DAO\AgenciaDAO;

/**
 * Description of ChamadasRN
 *
 * @author serbinario
 */
class AgenciaRN 
{
   /**
     *
     * @var type 
     */
    private $cbo;
    
    /**
     * 
     * @param AgenciaDAO $cbo
     */
    public function __construct(AgenciaDAO $cbo) 
    {
        $this->cbo = $cbo;
    }
    
    /**
     * 
     * @param Agencias $entity
     * @return type
     */
    public function save(Agencias $entity)
    {
        $result = $this->cbo->save($entity);
        
        return $result;
    }
    
    /**
     * 
     * @param Agencias $entity
     * @return type
     */
    public function update(Agencias $entity)
    {
        $result = $this->cbo->update($entity);
        
        return $result;
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function find($id)
    {        
        $result = $this->cbo->find($id);
        
        return $result;
    }
    
    /**
     * 
     * @return type
     */
    public function all()
    {
        $result = $this->cbo->all();
        
        return $result;
    } 
}
