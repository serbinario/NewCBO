<?php

namespace SerBinario\MBCredito\NewCBOBundle\DAO;

use SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalho;
use Doctrine\ORM\EntityManager;

/**
 * Description of ArquivoCabecalhoDAO
 *
 * @author serbinario
 */
class ArquivoCabecalhoDAO 
{
    /**
     *
     * @var type 
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
     * @param ArquivoCabecalho $entity
     * @return boolean
     */
    public function save(ArquivoCabecalho $entity)
    {
        try {
            $this->manager->persist($entity);
            $this->manager->flush();
            
            return $entity;
        } catch (\Exception $ex) {      
            return false;
        }
    }
    
    /**
     * 
     * @param ArquivoCabecalho $entity
     * @return boolean
     */
    public function update(ArquivoCabecalho $entity)
    {
        try {
            $this->manager->merge($entity);
            $this->manager->flush();
            
            return $entity;
        } catch (\Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param type $id
     * @return boolean
     */
    public function find($id)
    {
        try {
            $obj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalho")->find($id);            
            
            return $obj;
        } catch (\Exception $ex) {
            return false;
        }
    }
    
   /**
    * 
    * @return boolean
    */
    public function all()
    {
        try {
            $arrayObj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalho")->findAll();            
            
            return $arrayObj;
        } catch (\Exception $ex) {
            return false;
        }
    }
}
