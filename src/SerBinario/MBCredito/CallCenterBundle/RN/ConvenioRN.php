<?php
namespace SerBinario\MBCredito\CallCenterBundle\RN;

use SerBinario\MBCredito\CallCenterBundle\Entity\Convenios;
use SerBinario\MBCredito\CallCenterBundle\DAO\ConvenioDAO;

/**
 * Description of ConvenioRN
 *
 * @author serbinario
 */
class ConvenioRN 
{
   /**
     *
     * @var type 
     */
    private $cbo;
    
    /**
     * 
     * @param ConvenioDAO $cbo
     */
    public function __construct(ConvenioDAO $cbo) 
    {
        $this->cbo = $cbo;
    }
    
    /**
     * 
     * @param Convenios $entity
     * @return type
     */
    public function save(Convenios $entity)
    {
        $result = $this->cbo->save($entity);
        
        return $result;
    }
    
    /**
     * 
     * @param Convenios $entity
     * @return type
     */
    public function update(Convenios $entity)
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
