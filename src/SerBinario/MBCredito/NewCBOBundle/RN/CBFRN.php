<?php

namespace SerBinario\MBCredito\NewCBOBundle\RN;

use SerBinario\MBCredito\NewCBOBundle\DAO\ArquivoCabecalhoDAO;
use SerBinario\MBCredito\NewCBOBundle\DAO\TransacoesDAO;
use SerBinario\MBCredito\NewCBOBundle\DAO\OperadoresDAO;
use SerBinario\MBCredito\NewCBOBundle\DAO\LojasDAO;
use SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalho;
use SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes;
use SerBinario\MBCredito\NewCBOBundle\Entity\Operadores;
use SerBinario\MBCredito\NewCBOBundle\Entity\Lojas;

/**
 * Description of CBFRN
 *
 * @author serbinario
 */
class CBFRN 
{
    /**
     *
     * @var ArquivoCabecalhoDAO 
     */
    private $cboArquivoCabecalho;
    
    /**
     *
     * @var TransacoesDAO 
     */
    private $cboTransacoes;
    
    /**
     *
     * @var OperadoresDAO 
     */
    private $cboOperadores;
    
    /**
     *
     * @var LojasDAO 
     */
    private $cboLojas;
    
    /**
     * 
     * @param ArquivoCabecalhoDAO $cboArquivoCabecalho
     * @param TransacoesDAO $cboTransacoes
     * @param OperadoresDAO $cboOperadores
     * @param LojasDAO $cboLojas
     */
    public function __construct(ArquivoCabecalhoDAO $cboArquivoCabecalho,
            TransacoesDAO $cboTransacoes, 
            OperadoresDAO $cboOperadores, 
            LojasDAO $cboLojas) 
    {
        $this->cboArquivoCabecalho = $cboArquivoCabecalho;
        $this->cboTransacoes = $cboTransacoes;
        $this->cboOperadores = $cboOperadores;
        $this->cboLojas = $cboLojas;
    }
    
    /**
     * 
     * @param ArquivoCabecalho $arquivoCabecalho
     * @return boolean
     */
    public function salvar(ArquivoCabecalho $arquivoCabecalho)
    {
        try {
            #Recuperando as transações
            $transacoes = new \ArrayObject($arquivoCabecalho->getTransacoes()->toArray());
            
            #Removendo as transações
            #para salvar o arquivo separadamento no banco
            $arquivoCabecalho->setTransacoes(null);
            
            #Persistindo todo o cabeçalho do arquivo
            $this->cboArquivoCabecalho->save($arquivoCabecalho);            
            

            #Iterando e vinculando as transações
            for($i = 0; $i < $transacoes->count(); $i++) {
                #Recuperando objetos uteis
                $transacao   = $transacoes->offsetGet($i);            
                $operador    = $transacao->getOperadoresOperadores();
                $loja        = $transacao->getLojasLojas();           

//                #Recuperando o código da transação
//                $codOperacao = $transacao->getNumeroPropostaTransacoes();
                
//                #Recuperando o objeto da mesma operação do objeto corrente
//                $arrayObjTransVinculado = new \ArrayObject($this->cboTransacoes->findByCodOperacao($codOperacao));
//
//                #Se existir uma transação com mesmo código da operação vincula a transação corrente
//                if($arrayObjTransVinculado->count() > 0) {   
//                    $objTransVinculado = $arrayObjTransVinculado->offsetGet(0);
//                    $objTransVinculado->setTransacoesTransacoes($transacao);
//                    //$transacao->setTransacoesTransacoes($objTransVinculado);
//                }

                #Tratamento Operador
                $transacao->setOperadoresOperadores($this->tratamentoOperadores($operador));

                #Tratamento Lojas
                $transacao->setLojasLojas($this->tratamentoLojas($loja));  
                
                #persistindo a transação
                $this->cboTransacoes->save($transacao);
            }           
            

            #Retorno
            return true;
        } catch (Exception $ex) {
            return false;
        }
            
    }
    
    /**
     * 
     * @param Operadores $operadores
     * @return type
     */
    private function tratamentoOperadores(Operadores $operadores)
    {
        #Recuperando o operador da chave passada como parametro
        $arrayObjResult = new \ArrayObject($this->cboOperadores->findByChave($operadores->getCodOperadores()));
        
        #Verificando se o operador está cadastrado, se tiver retorna o mesmo
        if($arrayObjResult->count() > 0) {
            return $arrayObjResult->offsetGet(0);
        }
        
        #Sanvando o objeto operador
        $result = $this->cboOperadores->save($operadores);      
        
        #Retorno
        return $result;
    }
    
    /**
     * 
     * @param Lojas $lojas
     * @return type
     */
    private function tratamentoLojas(Lojas $lojas)
    {
        #Recuperando o operador da chave passada como parametro
        $arrayObjResult = new \ArrayObject($this->cboLojas->findByCodigo($lojas->getCodigoLojas()));
        
        #Verificando se a loja está cadastrada, se tiver retorna a mesma
        if($arrayObjResult->count() > 0) {
            return $arrayObjResult->offsetGet(0);
        }
        
        #Sanvando o objeto lojas
        $result = $this->cboLojas->save($lojas);
        
        #Retorno
        return $result;
    }
    
}
