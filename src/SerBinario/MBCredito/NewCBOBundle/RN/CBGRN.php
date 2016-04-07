<?php

namespace SerBinario\MBCredito\NewCBOBundle\RN;

use SerBinario\MBCredito\NewCBOBundle\DAO\ArquivoCabecalhoCBGDAO;
use SerBinario\MBCredito\NewCBOBundle\DAO\TransacoesCBGDAO;
use SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalhoCBG;
use SerBinario\MBCredito\NewCBOBundle\Entity\TransacoesCBG;


class CBGRN
{
    /**
     *
     * @var ArquivoCabecalhoCBGDAO
     */
    private $cboArquivoCabecalhoCBG;

    /**
     *
     * @var TransacoesCBGDAO
     */
    private $cboTransacoesCBG;
    

    /**
     *
     * @param ArquivoCabecalhoCBGDAO $cboArquivoCabecalhoCBG
     * @param TransacoesCBGDAO $cboTransacoesCBG
     */
    public function __construct(ArquivoCabecalhoCBGDAO $cboArquivoCabecalhoCBG, TransacoesCBGDAO $cboTransacoesCBG)
    {
        $this->cboArquivoCabecalhoCBG = $cboArquivoCabecalhoCBG;
        $this->cboTransacoesCBG = $cboTransacoesCBG;
    }

    /**
     *
     * @param ArquivoCabecalhoCBG $arquivoCabecalhoCBG
     * @return boolean
     */
    public function salvar(ArquivoCabecalhoCBG $arquivoCabecalhoCBG)
    {
        try {
            #Recuperando as transações
            $transacoes = new \ArrayObject($arquivoCabecalhoCBG->getTransacoesCBG()->toArray());

            #Removendo as transações
            #para salvar o arquivo separadamento no banco
            $arquivoCabecalhoCBG->setTransacoesCBG(null);

            #Persistindo todo o cabeçalho do arquivo
            $this->cboArquivoCabecalhoCBG->save($arquivoCabecalhoCBG);


            #Iterando e vinculando as transações
            for($i = 0; $i < $transacoes->count(); $i++) {
                #Recuperando objetos uteis
                $transacaoCBG   = $transacoes->offsetGet($i);

//                #Recuperando o código da transação
//                $codOperacao = $transacaoCBG->getNumeroPropostaTransacoesCBG();

//                #Recuperando o objeto da mesma operação do objeto corrente
//                $arrayObjTransVinculado = new \ArrayObject($this->cboTransacoesCBG->findByCodOperacao($codOperacao));
//
//                #Se existir uma transação com mesmo código da operação vincula a transação corrente
//                if($arrayObjTransVinculado->count() > 0) {   
//                    $objTransVinculado = $arrayObjTransVinculado->offsetGet(0);
//                    $objTransVinculado->setTransacoesCBGTransacoesCBG($transacaoCBG);
//                    //$transacaoCBG->setTransacoesCBGTransacoesCBG($objTransVinculado);
//                }

                #persistindo a transação
                $this->cboTransacoesCBG->save($transacaoCBG);
            }


            #Retorno
            return true;
        } catch (Exception $ex) {
            return false;
        }

    }
}