<?php

namespace SerBinario\MBCredito\NewCBOBundle\DAO;

use SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCBG;
use Doctrine\ORM\EntityManager;

class ArquivoCBGDAO
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
     * @param ArquivoCBG $entity
     * @return boolean
     */
    public function save(ArquivoCBG $entity)
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
     * @param type $name
     * @return type
     */
    public function findByName($name)
    {
        $result = $this->manager->getRepository("SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCBG")
            ->findBy(array("imageName" => $name));

        return $result;
    }
}