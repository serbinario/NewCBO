<?php
namespace SerBinario\MBCredito\CallCenterBundle\DAO;

use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\CallCenterBundle\Entity\Agencias;

/**
 * Description of AgenciasDAO
 *
 * @author serbinario
 */
class AgenciaDAO 
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
     * @param Agencias $entity
     * @return boolean|Agencias
     */
    public function save(Agencias $entity)
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
     * @param Agencias $entity
     * @return boolean|Agencias
     */
    public function update(Agencias $entity)
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
            $obj = $this->manager->getRepository("SerBinario\MBCredito\CallCenterBundle\Entity\Agencias")->find($id);
        
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
            $arrayObj = $this->manager->getRepository("SerBinario\MBCredito\CallCenterBundle\Entity\Agencias");
        
            return $arrayObj;
        } catch (Exception $ex) {
            return null;
        }
    }
}