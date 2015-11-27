<?php

namespace SerBinario\MBCredito\NewCBOBundle\DAO;

use SerBinario\MBCredito\NewCBOBundle\Entity\Operadores;
use Doctrine\ORM\EntityManager;

/**
 * Description of OperadoresDAO
 *
 * @author serbinario
 */
class OperadoresDAO
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
     * @param Operadores $entity
     * @return boolean
     */
    public function save(Operadores $entity)
    {
        try {
            $this->manager->persist($entity);
            $this->manager->flush();
                        
            return $entity;
        } catch (\Exception $ex) {
            if (!$this->manager->isOpen()) {
                $this->manager = $this->manager->create(
                $this->manager->getConnection(), $this->manager->getConfiguration());
                
                $this->manager->persist($entity);
                $this->manager->flush();
                
                return $entity;
            }
            
            return false;
        }
    }
    
    /**
     * 
     * @param Operadores $entity
     * @return boolean
     */
    public function update(Operadores $entity)
    {
        try {
            $this->manager->merge($entity);
            $this->manager->flush();
            
            return $entity;
        } catch (\Exception $ex) {
            return false;
        }
    }
    
    
    public function delete(Operadores $entity)
    {
         try {
            $this->manager->remove($entity);
            $this->manager->flush();
            
            return true;
        } catch (\Exception $ex) {
            var_dump($ex->getMessage());exit;
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
            $obj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\Operadores")->find($id);            
            
            return $obj;
        } catch (\Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param type $chave
     * @return boolean
     */
    public function findByChave($chave)
    {
        try {
            $obj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\Operadores")->findBy(array("codOperadores" => $chave));            
            
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
            $arrayObj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\Operadores")->findAll();            
            
            return $arrayObj;
        } catch (\Exception $ex) {
            return false;
        }
    }
}
