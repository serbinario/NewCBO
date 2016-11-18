<?php
namespace SerBinario\MBCredito\NewCBOBundle\DAO;

use SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCBF;
use Doctrine\ORM\EntityManager;

/**
 * Description of ArquivoCBFDAO
 *
 * @author serbinario
 */
class ArquivoCBFDAO
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
     * @param ArquivoCBF $entity
     * @return boolean
     */
    public function save(ArquivoCBF $entity)
    {
        try {
            $this->manager->persist($entity);
            $this->manager->flush();
            
            return $entity;
        } catch (\Exception $ex) {var_dump($ex->getMessage());exit;
            return false;
        }
    }
    
    /**
     * 
     * @param type $name
     * @return type
     */
    public function findByName($name)
    {
        $result = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCBF")
                    ->findBy(array("imageName" => $name));
        
        return $result;
    }
}
