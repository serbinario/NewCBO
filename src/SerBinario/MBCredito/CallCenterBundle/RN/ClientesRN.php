<?php
namespace SerBinario\MBCredito\CallCenterBundle\RN;

use SerBinario\MBCredito\CallCenterBundle\Entity\Clientes;
use SerBinario\MBCredito\CallCenterBundle\DAO\ClientesDAO;

/**
 * Description of ClientesRN
 *
 * @author serbinario
 */
class ClientesRN 
{
    /**
     *
     * @var type 
     */
    private $cbo;
    
    /**
     * 
     * @param ClientesDAO $cbo
     */
    public function __construct(ClientesDAO $cbo) 
    {
        $this->cbo = $cbo;
    }
    
    /**
     * 
     * @param Clientes $entity
     * @return type
     */
    public function save(Clientes $entity)
    {
        $result = $this->cbo->save($entity);
        
        return $result;
    }
    
    /**
     * 
     * @param Clientes $entity
     * @return type
     */
    public function update(Clientes $entity)
    {
        $result = $this->cbo->update($entity);
        
        return $result;
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function find($id)
    {        
        $result = $this->cbo->find($id);
        
        return $result;
    }
    
    /**
     * 
     * @return type
     */
    public function all()
    {
        $result = $this->cbo->all();
        
        return $result;
    }
    
    /**
     * 
     * @param type $ids
     * @return type
     */
    public function deleteTelefones($ids, $cliente)
    {
        $result = $this->cbo->deleteTelefones($ids, $cliente);
        
        return $result;
    }
}
