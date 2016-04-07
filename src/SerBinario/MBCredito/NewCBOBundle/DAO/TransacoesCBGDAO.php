<?php

namespace SerBinario\MBCredito\NewCBOBundle\DAO;

use SerBinario\MBCredito\NewCBOBundle\Entity\TransacoesCBG;
use Doctrine\ORM\EntityManager;

class TransacoesCBGDAO
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
     * @param TransacoesCBG $entity
     * @return boolean
     */
    public function save(TransacoesCBG $entity)
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
     * @param TransacoesCBG $entity
     * @return boolean
     */
    public function update(TransacoesCBG $entity)
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
            $obj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\TransacoesCBG")->find($id);

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
            $arrayObj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\TransacoesCBG")->findAll();

            return $arrayObj;
        } catch (\Exception $ex) {
            return false;
        }
    }    
}