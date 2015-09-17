<?php
namespace SerBinario\MBCredito\CallCenterBundle\DAO;

use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\CallCenterBundle\Entity\Clientes;

/**
 * Description of ClientesDAO
 *
 * @author serbinario
 */
class ClientesDAO
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
     * @param Clientes $entity
     * @return boolean|Clientes
     */
    public function save(Clientes $entity)
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
     * @param Clientes $entity
     * @return boolean|Clientes
     */
    public function update(Clientes $entity)
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
            $obj = $this->manager->getRepository("SerBinario\MBCredito\CallCenterBundle\Entity\Clientes")->find($id);
        
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
            $arrayObj = $this->manager->getRepository("SerBinario\MBCredito\CallCenterBundle\Entity\Clientes");
        
            return $arrayObj;
        } catch (Exception $ex) {
            return null;
        }
    }
    
    /**
     * 
     * @param type $ids
     * @return boolean
     */
    public function deleteTelefones($ids, $cliente)
    {
        try {
            if(count($ids) > 0) {
                $qb = $this->manager->createQueryBuilder();
                $qb->delete("SerBinario\MBCredito\CallCenterBundle\Entity\Telefones", "a") 
                    //->innerJoin("a.cliente", "b")
                    ->where($qb->expr()->notIn('a.id', ":ids"))
                    ->andWhere("a.cliente = :cliente")
                    ->setParameter("ids", $ids)
                    ->setParameter("cliente", $cliente);
                
                $qb->getQuery()->execute();
            }           
            
           return true; 
        } catch (Exception $ex) {
            return false;
        }
    }
}   
