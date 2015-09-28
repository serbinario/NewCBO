<?php
namespace SerBinario\MBCredito\CallCenterBundle\DAO;

use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\CallCenterBundle\Entity\Convenios;

/**
 * Description of ConvenioDAO
 *
 * @author serbinario
 */
class ConvenioDAO 
{
    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    private $manager;
    
    /**
     * 
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager) 
    {
        $this->manager = $manager;
    }
    
    /**
     * 
     * @param Convenio $entity
     * @return boolean|Convenios
     */
    public function save(Convenios $entity)
    {
        try {
            $this->manager->persist($entity);
            $this->manager->flush();
            
            return $entity;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param Convenio $entity
     * @return boolean|Convenios
     */
    public function update(Convenios $entity)
    {
        try {
            $this->manager->merge($entity);
            $this->manager->flush();
            
            return $entity;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function find($id)
    {
        try {
            $obj = $this->manager->getRepository("SerBinario\MBCredito\CallCenterBundle\Entity\Convenios")->find($id);
        
            return $obj;
        } catch (Exception $ex) {
            return null;
        }
    }
    
    /**
     * 
     * @return type
     */
    public function all()
    {
         try {
            $arrayObj = $this->manager->getRepository("SerBinario\MBCredito\CallCenterBundle\Entity\Convenios");
        
            return $arrayObj;
        } catch (Exception $ex) {
            return null;
        }
    }
}