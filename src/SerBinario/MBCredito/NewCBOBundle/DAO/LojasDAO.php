<?php

namespace SerBinario\MBCredito\NewCBOBundle\DAO;

use SerBinario\MBCredito\NewCBOBundle\Entity\Lojas;
use Doctrine\ORM\EntityManager;

/**
 * Description of LojasDAO
 *
 * @author serbinario
 */
class LojasDAO 
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
     * @param Lojas $entity
     * @return boolean
     */
    public function save(Lojas $entity)
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
     * @param Lojas $entity
     * @return boolean
     */
    public function update(Lojas $entity)
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
            $obj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\Lojas")->find($id);            
            
            return $obj;
        } catch (\Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param type $codigo
     * @return boolean
     */
    public function findByCodigo($codigo)
    {
        try {
            $obj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\Lojas")
                    ->findBy(array("codigoLojas" => $codigo));            
            
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
            $arrayObj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\Lojas")->findAll();            
            
            return $arrayObj;
        } catch (\Exception $ex) {
            return false;
        }
    }
}
