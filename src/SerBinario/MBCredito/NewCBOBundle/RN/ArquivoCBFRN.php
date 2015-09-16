<?php
namespace SerBinario\MBCredito\NewCBOBundle\RN;

use SerBinario\MBCredito\NewCBOBundle\DAO\ArquivoCBFDAO;
use SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCBF;

/**
 * Description of ArquivoCBFRN
 *
 * @author serbinario
 */
class ArquivoCBFRN 
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
    public function __construct(ArquivoCBFDAO $dao)
    {
        $this->dao = $dao;
    }
    
    /**
     * 
     * @param ArquivoCBF $entity
     * @return type
     */
    public function save(ArquivoCBF $entity)
    {
        $result = $this->dao->save($entity);
        
        return $result;
    }
    
     /**
     * 
     * @param type $name
     * @return type
     */
    public function findByName($name)
    {
        $result = $this->dao->findByName($name);
        
        return $result;
    }
}
