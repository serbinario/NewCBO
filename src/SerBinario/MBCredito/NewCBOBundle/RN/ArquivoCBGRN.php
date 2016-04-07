<?php

namespace SerBinario\MBCredito\NewCBOBundle\RN;

use SerBinario\MBCredito\NewCBOBundle\DAO\ArquivoCBGDAO;
use SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCBG;

class ArquivoCBGRN
{
    /**
     *
     * @var type
     */
    private $dao;

    /**
     *
     * @param ArquivoCBGDAO $dao
     */
    public function __construct(ArquivoCBGDAO $dao)
    {
        $this->dao = $dao;
    }

    /**
     *
     * @param ArquivoCBG $entity
     * @return type
     */
    public function save(ArquivoCBG $entity)
    {
        $result = $this->dao->save($entity);

        return $result;
    }

    /**
     *
     * @param type $name
     * @return type
     */
    public function findByName($name)
    {
        $result = $this->dao->findByName($name);

        return $result;
    }
}