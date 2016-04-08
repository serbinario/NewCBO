<?php

namespace SerBinario\MBCredito\NewCBOBundle\DAO;

use SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalhoCBG;
use Doctrine\ORM\EntityManager;

class ArquivoCabecalhoCBGDAO
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
     * @param ArquivoCabecalhoCBG $entity
     * @return boolean
     */
    public function save(ArquivoCabecalhoCBG $entity)
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
     * @param ArquivoCabecalhoCBG $entity
     * @return boolean
     */
    public function update(ArquivoCabecalhoCBG $entity)
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
            $obj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalhoCBG")->find($id);

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
            $arrayObj = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalhoCBG")->findAll();

            return $arrayObj;
        } catch (\Exception $ex) {
            return false;
        }
    }

    /**
     *
     * @return type
     */
    public function findLastsDesc()
    {
        try {
            $arrayObj = $this->manager->createQueryBuilder()
                ->select("a")
                ->from("SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalhoCBG", "a")
                ->join("a.arquivoCBG", "b")
                ->orderBy("a.id", "DESC")
                ->setMaxResults(15)
                ->getQuery()
                ->getResult();

            return $arrayObj;
        } catch (\Exception $ex) {
            return null;
        }
    }
}