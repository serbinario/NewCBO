<?php
namespace SerBinario\MBCredito\CallCenterBundle\DAO;

use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\CallCenterBundle\Entity\Chamadas;

/**
 * Description of ChamadasDAO
 *
 * @author serbinario
 */
class ChamadasDAO 
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
     * @param Chamadas $entity
     * @return boolean|Chamadas
     */
    public function save(Chamadas $entity)
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
     * @param Chamadas $entity
     * @return boolean|Chamadas
     */
    public function update(Chamadas $entity)
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
            $obj = $this->manager->getRepository("SerBinario\MBCredito\CallCenterBundle\Entity\Chamadas")->find($id);
        
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
            $arrayObj = $this->manager->getRepository("SerBinario\MBCredito\CallCenterBundle\Entity\Chamadas");
        
            return $arrayObj;
        } catch (Exception $ex) {
            return null;
        }
    }
}