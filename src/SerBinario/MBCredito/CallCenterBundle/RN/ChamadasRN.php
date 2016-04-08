<?php
namespace SerBinario\MBCredito\CallCenterBundle\RN;

use SerBinario\MBCredito\CallCenterBundle\Entity\Chamadas;
use SerBinario\MBCredito\CallCenterBundle\DAO\ChamadasDAO;

/**
 * Description of ChamadasRN
 *
 * @author serbinario
 */
class ChamadasRN 
{
   /**
     *
     * @var type 
     */
    private $cbo;
    
    /**
     * 
     * @param ChamadasDAO $cbo
     */
    public function __construct(ChamadasDAO $cbo) 
    {
        $this->cbo = $cbo;
    }
    
    /**
     * 
     * @param Chamadas $entity
     * @return type
     */
    public function save(Chamadas $entity)
    {
        $result = $this->cbo->save($entity);
        
        return $result;
    }
    
    /**
     * 
     * @param Chamadas $entity
     * @return type
     */
    public function update(Chamadas $entity)
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
