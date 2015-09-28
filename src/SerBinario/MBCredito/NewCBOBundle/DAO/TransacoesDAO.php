<?php

namespace SerBinario\MBCredito\NewCBOBundle\DAO;

use SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes;
use Doctrine\ORM\EntityManager;

/**
 * Description of TransacoesDAO
 *
 * @author serbinario
 */
class TransacoesDAO 
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
     * @param Transacoes $entity
     * @return boolean
     */
    public function save(Transacoes $entity)
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
     * @param Transacoes $entity
     * @return boolean
     */
    public function update(Transacoes $entity)
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
            $obj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes")->find($id);            
            
            return $obj;
        } catch (\Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param type $codOperacao
     * @return boolean
     */
    public function findByCodOperacao($codOperacao, $codigoTransacao, $data = array())
    {
       try {
            $qb = $this->manager->createQueryBuilder();
            $qb->select("a");
            $qb->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a");           
            $qb->where("a.numeroPropostaTransacoes = :codOperacao");
            $qb->andWhere("a.codTransacoes = :codigo");
            
            if(count($data) == 2) {
                $qb->andWhere($qb->expr()->between("a.dataTransacoes", ":dataIn", ":dataFin"));
                $qb->setParameter("dataIn", $data['dataIn']->format("Y-m-d"));
                $qb->setParameter("dataFin", $data["dataFi"]->format("Y-m-d"));
            }          
            
            $qb->setParameter("codOperacao", $codOperacao);
            $qb->setParameter("codigo", $codigoTransacao);
            
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $ex) {            
            return null;
        }
    }
    
   /**
    * 
    * @return boolean
    */
    public function all()
    {
        try {
            $arrayObj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes")->findAll();            
            
            return $arrayObj;
        } catch (\Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param type $codigo
     * @return boolean
     */
    public function findByCodTransacao($codigo, $data = array(), $operador = "")
    {
        try {
            $qb = $this->manager->createQueryBuilder();
            $qb->select("a");
            $qb->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a");
            $qb->join("a.operadoresOperadores", "b");
            $qb->where("b.idOperadores = :operador");
            $qb->andWhere("a.codTransacoes = :codigo");
            
            if(count($data) == 2) {
                $qb->andWhere($qb->expr()->between("a.dataTransacoes", ":dataIn", ":dataFin"));
                $qb->setParameter("dataIn", $data['dataIn']->format("Y-m-d"));
                $qb->setParameter("dataFin", $data["dataFi"]->format("Y-m-d"));
            }
            
            $qb->setParameter("operador", $operador);
            $qb->setParameter("codigo", $codigo);
            
            return $qb->getQuery()->getResult();
        } catch (\Exception $ex) {            
            return null;
        }
    }
    
    
       
}