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
    public function findByCodOperacao($codOperacao)
    {
        try {
            $obj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes")
                    ->findBy(array("numeroPropostaTransacoes" =>  $codOperacao));            
           
            return $obj;
        } catch (\Exception $ex) {
            //print_r($ex->getMessage());exit;
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
            $arrayObj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes")
                    ->findBy(array("codTransacoes" => $codigo));            
            
            return $arrayObj;
        } catch (\Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param type $idOperador
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findByOperadorBetweenDateBruto($idOperador, $dateIni = "", $dateFin = "")
    {
        try {
            $qb = $this->manager->createQueryBuilder();
            $qb->select("sum(a.valorTransacoes)");
            $qb->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a");
            $qb->join("a.operadoresOperadores", "b");    
            $qb->leftJoin("a.transacoesTransacoes", "c");
            $qb->where("b.idOperadores = :idOperadores");
            $qb->andWhere("a.codTransacoes = '065'");            
            $qb->setParameter("idOperadores", $idOperador);   
            
            $qb2 = $this->manager->createQueryBuilder();
            $qb2->select("a1.numeroPropostaTransacoes");
            $qb2->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a1");            
            $qb2->join("a1.operadoresOperadores", "b1");
            $qb2->where("b1.idOperadores = :idOperadores");
            $qb2->andWhere("a1.codTransacoes='068'");   
            $qb2->setParameter("idOperadores", $idOperador);            
   
            if(!empty($dateIni) && !empty($dateFin)) { 
                $qb2->andWhere('a1.dataTransacoes BETWEEN :from AND :to');
                $qb2->setParameter("from", $dateIni);
                $qb2->setParameter("to", $dateFin);
                
                $qb->andWhere('a.dataTransacoes BETWEEN :from AND :to');
                $qb->setParameter("from", $dateIni);
                $qb->setParameter("to", $dateFin);
            }
            
            $qb->andWhere($qb->expr()->in("a.numeroPropostaTransacoes", $qb2->getDQL()));
          
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $ex) {          
            return null;
        }
    }
    
    /**
     * 
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findByOperadoresByEstadoBetweenDateBruto($estado, $dateIni = "", $dateFin = "")
    {
        try {
            $qb = $this->manager->createQueryBuilder();
            $qb->select("sum(a.valorTransacoes)");
            $qb->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a");            
            $qb->join("a.operadoresOperadores", "b");
            $qb->join("a.lojasLojas", "d");            
            $qb->where("a.codTransacoes='065'");     
            $qb->andWhere("d.codigoLojas = :estado");               
            $qb->setParameter("estado", $estado);
            
            $qb1 = $this->manager->createQueryBuilder();
            $qb1->select("a2.idOperadores");
            $qb1->from("SerBinario\MBCredito\NewCBOBundle\Entity\Operadores", "a2");    
            
            $qb3 = $this->manager->createQueryBuilder();
            $qb3->select("a3.idOperadores");
            $qb3->from("SerBinario\MBCredito\NewCBOBundle\Entity\Operadores", "a3");
            
            $qb2 = $this->manager->createQueryBuilder();
            $qb2->select("a1.numeroPropostaTransacoes");
            $qb2->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a1");            
            $qb2->join("a1.operadoresOperadores", "b1");
            $qb2->where($qb->expr()->in("b1.idOperadores", $qb3->getDQL()));
            $qb2->andWhere("a1.codTransacoes='068'");              
            
            if(!empty($dateIni) && !empty($dateFin)) { 
                $qb2->andWhere('a1.dataTransacoes BETWEEN :from AND :to');
                $qb2->setParameter("from", '2015-07-30');
                $qb2->setParameter("to", '2015-07-30');
                
                $qb->andWhere('a.dataTransacoes BETWEEN :from AND :to');
                $qb->setParameter("from", '2015-07-30');
                $qb->setParameter("to", '2015-07-30');
            }
            
            $qb->andWhere($qb->expr()->in("a.numeroPropostaTransacoes", $qb2->getDQL()));
            $qb->andWhere($qb->expr()->in("b.idOperadores", $qb1->getDQL()));
            
            
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $ex) {       
            return null;
        }
    }
    
    /**
     * 
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findTotalDateBruto($dateIni = "", $dateFin = "")
    {
        try {
            $qb = $this->manager->createQueryBuilder();
            $qb->select("sum(a.valorTransacoes)");
            $qb->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a");            
            $qb->join("a.operadoresOperadores", "b");
            $qb->join("a.lojasLojas", "d");            
            $qb->where("a.codTransacoes='065'");       
            
            $qb1 = $this->manager->createQueryBuilder();
            $qb1->select("a2.idOperadores");
            $qb1->from("SerBinario\MBCredito\NewCBOBundle\Entity\Operadores", "a2");    
            
            $qb3 = $this->manager->createQueryBuilder();
            $qb3->select("a3.idOperadores");
            $qb3->from("SerBinario\MBCredito\NewCBOBundle\Entity\Operadores", "a3");
            
            $qb2 = $this->manager->createQueryBuilder();
            $qb2->select("a1.numeroPropostaTransacoes");
            $qb2->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a1");            
            $qb2->join("a1.operadoresOperadores", "b1");
            $qb2->where($qb->expr()->in("b1.idOperadores", $qb3->getDQL()));
            $qb2->andWhere("a1.codTransacoes='068'");              
            
            if(!empty($dateIni) && !empty($dateFin)) { 
                $qb2->andWhere('a1.dataTransacoes BETWEEN :from AND :to');
                $qb2->setParameter("from", '2015-07-30');
                $qb2->setParameter("to", '2015-07-30');
                
                $qb->andWhere('a.dataTransacoes BETWEEN :from AND :to');
                $qb->setParameter("from", '2015-07-30');
                $qb->setParameter("to", '2015-07-30');
            }
            
            $qb->andWhere($qb->expr()->in("a.numeroPropostaTransacoes", $qb2->getDQL()));
            $qb->andWhere($qb->expr()->in("b.idOperadores", $qb1->getDQL()));
            
            
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $ex) {       
            return null;
        }
    }
    
    
    
    /**
     * 
     * @param type $idOperador
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findByOperadorBetweenDateLiquido($idOperador, $dateIni = "", $dateFin = "")
    {
        try {         
            $qb = $this->manager->createQueryBuilder();
            $qb->select("sum(a.valorTransacoes)");
            $qb->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a");            
            $qb->join("a.operadoresOperadores", "b");
            $qb->where("b.idOperadores = :idOperadores");
            $qb->andWhere("a.codTransacoes='068'");           
            $qb->setParameter("idOperadores", $idOperador);            
            
            if(!empty($dateIni) && !empty($dateFin)) {
//                $qb2 = $this->manager->createQueryBuilder();
//                $qb2->select("a1.numeroPropostaTransacoes");
//                $qb2->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a1");            
//                $qb2->join("a1.operadoresOperadores", "b1");
//                $qb2->where("b1.idOperadores = :idOperadores");
//                $qb2->andWhere("a1.codTransacoes='065'");   
//                $qb2->andWhere('a1.dataTransacoes BETWEEN :from AND :to');
//                $qb2->setParameter("idOperadores", $idOperador);  
//                $qb2->setParameter("from", $dateIni);
//                $qb2->setParameter("to", $dateFin);
//                $qb->andWhere($qb->expr()->in("a.numeroPropostaTransacoes", $qb2->getDQL()));
                
                $qb->andWhere('a.dataTransacoes BETWEEN :from AND :to');               
                $qb->setParameter("from", $dateIni);
                $qb->setParameter("to", $dateFin);                
            }
           
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $ex) {           
            return null;
        }
    }
    
    /**
     * 
     * @param type $idOperador
     * @param type $estado
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findByOperadoresByEstadoBetweenDateLiquido($estado, $dateIni = "", $dateFin = "")
    {
        try {         
            $qb = $this->manager->createQueryBuilder();
            $qb->select("sum(a.valorTransacoes)");
            $qb->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a");            
            $qb->join("a.operadoresOperadores", "b");
            $qb->join("a.lojasLojas", "d");            
            $qb->where("a.codTransacoes='068'");     
            $qb->andWhere("d.codigoLojas = :estado");                
            $qb->setParameter("estado", $estado);  
            
            $qb1 = $this->manager->createQueryBuilder();
            $qb1->select("a2.idOperadores");
            $qb1->from("SerBinario\MBCredito\NewCBOBundle\Entity\Operadores", "a2");
            
            $qb->andWhere($qb->expr()->in("b.idOperadores", $qb1->getDQL()));
            
            if(!empty($dateIni) && !empty($dateFin)) {
//                $qb2 = $this->manager->createQueryBuilder();
//                $qb2->select("a1.numeroPropostaTransacoes");
//                $qb2->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a1");            
//                $qb2->join("a1.operadoresOperadores", "b1");
//                $qb2->where("b1.idOperadores = :idOperadores");
//                $qb2->andWhere("a1.codTransacoes='065'");   
//                $qb2->andWhere('a1.dataTransacoes BETWEEN :from AND :to');
//                $qb2->setParameter("idOperadores", $idOperador);  
//                $qb2->setParameter("from", $dateIni);
//                $qb2->setParameter("to", $dateFin);
//                $qb->andWhere($qb->expr()->in("a.numeroPropostaTransacoes", $qb2->getDQL()));
                
                $qb->andWhere('a.dataTransacoes BETWEEN :from AND :to');               
                $qb->setParameter("from", $dateIni);
                $qb->setParameter("to", $dateFin);                
            }
           
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $ex) {           
            return null;
        }
    }
    
    /**
     * 
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findTotalDateLiquido($dateIni = "", $dateFin = "")
    {
        try {         
            $qb = $this->manager->createQueryBuilder();
            $qb->select("sum(a.valorTransacoes)");
            $qb->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a");            
            $qb->join("a.operadoresOperadores", "b");
            $qb->join("a.lojasLojas", "d");            
            $qb->where("a.codTransacoes='068'");        
            
            $qb1 = $this->manager->createQueryBuilder();
            $qb1->select("a2.idOperadores");
            $qb1->from("SerBinario\MBCredito\NewCBOBundle\Entity\Operadores", "a2");
            
            $qb->andWhere($qb->expr()->in("b.idOperadores", $qb1->getDQL()));
            
            if(!empty($dateIni) && !empty($dateFin)) {
//                $qb2 = $this->manager->createQueryBuilder();
//                $qb2->select("a1.numeroPropostaTransacoes");
//                $qb2->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a1");            
//                $qb2->join("a1.operadoresOperadores", "b1");
//                $qb2->where("b1.idOperadores = :idOperadores");
//                $qb2->andWhere("a1.codTransacoes='065'");   
//                $qb2->andWhere('a1.dataTransacoes BETWEEN :from AND :to');
//                $qb2->setParameter("idOperadores", $idOperador);  
//                $qb2->setParameter("from", $dateIni);
//                $qb2->setParameter("to", $dateFin);
//                $qb->andWhere($qb->expr()->in("a.numeroPropostaTransacoes", $qb2->getDQL()));
                
                $qb->andWhere('a.dataTransacoes BETWEEN :from AND :to');               
                $qb->setParameter("from", $dateIni);
                $qb->setParameter("to", $dateFin);                
            }
           
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $ex) {           
            return null;
        }
    }
    
     /**
     * 
     * @param type $idOperador
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findByOperadorBetweenDateTrocoLiquido($idOperador, $dateIni = "", $dateFin = "")
    {
        try {
            $qb = $this->manager->createQueryBuilder();
            $qb->select("sum(a.valorTrocoTransacoes)");
            $qb->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a");           
            $qb->join("a.operadoresOperadores", "b");
            $qb->where("b.idOperadores = :idOperadores");
            $qb->andWhere("a.codTransacoes = '068' ");            
            $qb->setParameter("idOperadores", $idOperador);             
            
            if(!empty($dateIni) && !empty($dateFin)) {
//                $qb2 = $this->manager->createQueryBuilder();
//                $qb2->select("a1.numeroPropostaTransacoes");
//                $qb2->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a1");            
//                $qb2->join("a1.operadoresOperadores", "b1");
//                $qb2->where("b1.idOperadores = :idOperadores");
//                $qb2->andWhere("a1.codTransacoes='065'");   
//                $qb2->andWhere('a1.dataTransacoes BETWEEN :from AND :to');
//                $qb2->setParameter("idOperadores", $idOperador);  
//                $qb2->setParameter("from", $dateIni);
//                $qb2->setParameter("to", $dateFin);
//                $qb->andWhere($qb->expr()->in("a.numeroPropostaTransacoes", $qb2->getDQL()));
                
                $qb->andWhere('a.dataTransacoes BETWEEN :from AND :to');
                $qb->setParameter("from", $dateIni);
                $qb->setParameter("to", $dateFin);
            }
            
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $ex) {            
            return null;
        }
    }
    
    /**
     *
     * @param type $estado
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findByOperadoresByEstadoBetweenDateTrocoLiquido($estado, $dateIni = "", $dateFin = "")
    {
        try {
            $qb = $this->manager->createQueryBuilder();
            $qb->select("sum(a.valorTrocoTransacoes)");
            $qb->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a");           
            $qb->join("a.operadoresOperadores", "b");
            $qb->join("a.lojasLojas", "d");            
            $qb->where("a.codTransacoes = '068' ");    
            $qb->andWhere("d.codigoLojas = :estado");            
            $qb->setParameter("estado", $estado); 
            
            $qb1 = $this->manager->createQueryBuilder();
            $qb1->select("a2.idOperadores");
            $qb1->from("SerBinario\MBCredito\NewCBOBundle\Entity\Operadores", "a2");     
            
            $qb->andWhere($qb->expr()->in("b.idOperadores", $qb1->getDQL())); 
            
            if(!empty($dateIni) && !empty($dateFin)) {
//                $qb2 = $this->manager->createQueryBuilder();
//                $qb2->select("a1.numeroPropostaTransacoes");
//                $qb2->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a1");            
//                $qb2->join("a1.operadoresOperadores", "b1");
//                $qb2->where($qb->expr()->in("b.idOperadores", ":idOperadores"));
//                $qb2->andWhere("a1.codTransacoes='065'");   
//                $qb2->andWhere('a1.dataTransacoes BETWEEN :from AND :to');
//                $qb2->setParameter("idOperadores", $idOperador);  
//                $qb2->setParameter("from", $dateIni);
//                $qb2->setParameter("to", $dateFin);
//                $qb->andWhere($qb->expr()->in("a.numeroPropostaTransacoes", $qb2->getDQL()));
                
                $qb->andWhere('a.dataTransacoes BETWEEN :from AND :to');
                $qb->setParameter("from", $dateIni);
                $qb->setParameter("to", $dateFin);
            }
            
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $ex) {            
            return null;
        }
    }
    
    /**
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findTotalnDateTrocoLiquido($dateIni = "", $dateFin = "")
    {
        try {
            $qb = $this->manager->createQueryBuilder();
            $qb->select("sum(a.valorTrocoTransacoes)");
            $qb->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a");           
            $qb->join("a.operadoresOperadores", "b");
            $qb->join("a.lojasLojas", "d");            
            $qb->where("a.codTransacoes = '068' ");    
            
            $qb1 = $this->manager->createQueryBuilder();
            $qb1->select("a2.idOperadores");
            $qb1->from("SerBinario\MBCredito\NewCBOBundle\Entity\Operadores", "a2");     
            
            $qb->andWhere($qb->expr()->in("b.idOperadores", $qb1->getDQL())); 
            
            if(!empty($dateIni) && !empty($dateFin)) {
//                $qb2 = $this->manager->createQueryBuilder();
//                $qb2->select("a1.numeroPropostaTransacoes");
//                $qb2->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a1");            
//                $qb2->join("a1.operadoresOperadores", "b1");
//                $qb2->where($qb->expr()->in("b.idOperadores", ":idOperadores"));
//                $qb2->andWhere("a1.codTransacoes='065'");   
//                $qb2->andWhere('a1.dataTransacoes BETWEEN :from AND :to');
//                $qb2->setParameter("idOperadores", $idOperador);  
//                $qb2->setParameter("from", $dateIni);
//                $qb2->setParameter("to", $dateFin);
//                $qb->andWhere($qb->expr()->in("a.numeroPropostaTransacoes", $qb2->getDQL()));
                
                $qb->andWhere('a.dataTransacoes BETWEEN :from AND :to');
                $qb->setParameter("from", $dateIni);
                $qb->setParameter("to", $dateFin);
            }
            
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $ex) {            
            return null;
        }
    }
    
     /**
     * 
     * @param type $idOperador
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findByOperadorBetweenDateCancelado($idOperador, $dateIni = "", $dateFin = "")
    {
        try {
            $qb = $this->manager->createQueryBuilder();
            $qb->select("sum(a.valorTransacoes)");
            $qb->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a");
            $qb->join("a.operadoresOperadores", "b");            
            $qb->where("b.idOperadores = :idOperadores");
            $qb->andWhere("a.codTransacoes = '069'");            
            $qb->setParameter("idOperadores", $idOperador);            
            
            if(!empty($dateIni) && !empty($dateFin)) {
//                $qb2 = $this->manager->createQueryBuilder();
//                $qb2->select("a1.numeroPropostaTransacoes");
//                $qb2->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a1");            
//                $qb2->join("a1.operadoresOperadores", "b1");
//                $qb2->where("b1.idOperadores = :idOperadores");
//                $qb2->andWhere("a1.codTransacoes='065'");   
//                $qb2->andWhere('a1.dataTransacoes BETWEEN :from AND :to');
//                $qb2->setParameter("idOperadores", $idOperador);  
//                $qb2->setParameter("from", $dateIni);
//                $qb2->setParameter("to", $dateFin);
//                $qb->andWhere($qb->expr()->in("a.numeroPropostaTransacoes", $qb2->getDQL()));
                
                $qb->andWhere('a.dataTransacoes BETWEEN :from AND :to');
                $qb->setParameter("from", $dateIni);
                $qb->setParameter("to", $dateFin);
            }
            
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $ex) {
            return null;
        }
    }
    
    /**
     * 
     * @param type $idOperador
     * @param type $dateIni
     * @param type $dateFin
     * @return type
     */
    public function findByOperadorBetweenDateTrocoCancelado($idOperador, $dateIni = "", $dateFin ="")
    {
        try {
            $qb = $this->manager->createQueryBuilder();
            $qb->select("sum(a.valorTrocoTransacoes)");
            $qb->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a");
            $qb->join("a.operadoresOperadores", "b");
            $qb->innerJoin("a.transacoesTransacoes", "c");
            $qb->where("b.idOperadores = :idOperadores");
            $qb->andWhere("a.codTransacoes = '069'");            
            $qb->setParameter("idOperadores", $idOperador);            
            
            if(!empty($dateIni) && !empty($dateFin)) {
//                $qb2 = $this->manager->createQueryBuilder();
//                $qb2->select("a1.numeroPropostaTransacoes");
//                $qb2->from("SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes", "a1");            
//                $qb2->join("a1.operadoresOperadores", "b1");
//                $qb2->where("b1.idOperadores = :idOperadores");
//                $qb2->andWhere("a1.codTransacoes='065'");   
//                $qb2->andWhere('a1.dataTransacoes BETWEEN :from AND :to');
//                $qb2->setParameter("idOperadores", $idOperador);  
//                $qb2->setParameter("from", $dateIni);
//                $qb2->setParameter("to", $dateFin);
//                $qb->andWhere($qb->expr()->in("a.numeroPropostaTransacoes", $qb2->getDQL()));
                
                $qb->andWhere('a.dataTransacoes BETWEEN :from AND :to');
                $qb->setParameter("from", $dateIni);
                $qb->setParameter("to", $dateFin);
            }
            
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $ex) {
            return null;
        }
    }
}
