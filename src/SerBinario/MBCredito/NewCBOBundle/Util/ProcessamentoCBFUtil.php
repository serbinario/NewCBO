<?php

namespace SerBinario\MBCredito\NewCBOBundle\Util;

use SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalho;
use SerBinario\MBCredito\NewCBOBundle\Entity\Transacoes;
use SerBinario\MBCredito\NewCBOBundle\Entity\Operadores;
use SerBinario\MBCredito\NewCBOBundle\Entity\Lojas;

/**
 * Description of TratamentoCBFUtil
 *
 * @author serbinario
 */
class ProcessamentoCBFUtil 
{
    /**
     * 
     * @param type $fileName
     * @return ArquivoCabecalho
     * @throws \InvalidArgumentException
     */
   public static function processar($fileName)
   {      
       #Variável de escopo
       $arquivoCabecalho  = new ArquivoCabecalho();
       
       #caminho do arquivo
       $path = __DIR__.'/../../../../../web/upload/files/'.$fileName;
       
       #Verifica se p arquivo existe
      // if(!file_exists($path) || empty($fileName)) {
      //     throw new \InvalidArgumentException("Arquivo não encontrado ou caminho vazio");
      //}
       
       #Recuperando as linhas do arquivo como array
       #e transformando em um objeto array
       $linesObject = new \ArrayObject(\file($path));
       
       #Varredura do $linesObject e 
       #criação do array de Objetos de Arquivo
       for($i = 0; $i < $linesObject->count(); $i++) {
           #Variáveis de armazenamento dos objetos           
           $transacoes       = new Transacoes();
           $operadores       = new Operadores();
           $lojas            = new Lojas();
           
           #Recuperando a próxima linha
           $line             = $linesObject->offsetGet($i);     
           #Recuperando o tipo da linha
           $typeLine         = \substr($line, 0, 1);

           $cabecallho = $arquivoCabecalho->getNomeArquivoCabecalho();


           #Tratamento do cabeçalho do arquivo


           if($typeLine == 0) {
               $arquivoCabecalho->setBancoArquivoCabecalho(substr($line, 1, 3));
               $arquivoCabecalho->setDataArquivoCabecalho(\DateTime::createFromFormat('Y/m/d', substr($line, 4,4) . "/" . substr($line, 8,2) . "/" .substr($line, 10,2)));
               $arquivoCabecalho->setNomeArquivoCabecalho(substr($line, 12, 6));
               $arquivoCabecalho->setCodRemessaArquivoCabecalho(substr($line, 18,9));
               $arquivoCabecalho->setSeqCorrespondenteArquivoCabecalho(substr($line, 27,9));
               $arquivoCabecalho->setCodMciCorrespondenteArquivoCabecalho(substr($line, 36,9));
           }

           //if( $cabecallho == 'CBF801')
           #Tratamento das transações
           if(($typeLine == 1 && $cabecallho == 'CBF800') || ($typeLine == 2 && $cabecallho == 'CBF801') ) {
               $transacoes->setBancoTransacoes(substr($line, 1,3));
               $transacoes->setBancoTransacoes(substr($line, 1,3));
               $transacoes->setDataTransacoes(\DateTime::createFromFormat('Y/m/d', substr($line, 4,4) . "/" . substr($line, 8,2) . "/" .substr($line, 10,2)));
               $transacoes->setCodAgenciaRelTransacoes(substr($line, 12,4));
               
               #Operador
               $operadores->setCodOperadores(substr($line, 16,8));
               $transacoes->setOperadoresOperadores($operadores);
               ###################################################
               
               $transacoes->setCodSequenciaOpTransacoes(substr($line, 24,4));
               $transacoes->setCodTransacoes(substr($line, 28,3));
               $transacoes->setDataMovimentoTransacoes(\DateTime::createFromFormat('Y/m/d', substr($line, 31,4) . "/" . substr($line, 35,2) . "/" .substr($line, 37,2)));
               $transacoes->setHoraTransacoes(\DateTime::createFromFormat('H:i:s', substr($line, 39,2) . ":" . substr($line, 41,2) . ":" .substr($line, 43,2)));
               $transacoes->setValorTransacoes(substr($line, 45,15) .".".substr($line, 60,2));   
               
               #Lojas
               $lojas->setCodigoLojas(substr($line, 62,4));
               $transacoes->setLojasLojas($lojas);
               ###################################################
               
               $transacoes->setCodPdvTransacoes(substr($line, 66,4));
               $transacoes->setFormaLiqTransacoes(substr($line, 70,2));
               $transacoes->setSituacaoDocTransacoes(substr($line, 72,3));
               $transacoes->setRetornoCorresTransacoes(substr($line, 75,5));        
               
               #Adicionando a transação ao objeto do arquivo
               $arquivoCabecalho->addTransacoes($transacoes);
           }
           
           #Tratamento da operação
           if(($typeLine == 2 && $cabecallho == 'CBF800') || ($typeLine == 3 && $cabecallho == 'CBF801')) {
               #Recuperando a última transação armazenada
               $transacaoCorrente = $arquivoCabecalho->getTransacoes()->last();
               
               $transacaoCorrente->setCodLinhaTransacoes(substr($line, 1,4));
               $transacaoCorrente->setNumeroConvenioTransacoes(substr($line, 5,9));
               $transacaoCorrente->setNumeroPropostaTransacoes(substr($line, 14,9));
               $transacaoCorrente->setTipoLiberacaoTransacoes(substr($line, 23,4));
               $transacaoCorrente->setQtdParcelasTransacoes(substr($line, 27,5));
               $transacaoCorrente->setNumeroPropVinculadaTransacoes(substr($line, 31,9));
               $transacaoCorrente->setValorTrocoTransacoes(substr($line, 40,15). "." .substr($line, 55,2));
               $transacaoCorrente->setCustoConvenioTransacoes(substr($line, 57,4));
               $transacaoCorrente->setSeguimentoConvenioTransacoes(substr($line, 61,4));
               $transacaoCorrente->setTaxaMensalTransacoes(substr($line, 65,4));
           }
       }
       
       #Retorno
       return $arquivoCabecalho;
   }
   
   public static function montarArrayRetorno($transacoes)
   {
       #Variáveis de ultilização
       $objArrayTrans    = new \ArrayObject($transacoes);
       $objArrayRetorno  = new \ArrayObject();
       $contArrayRetorno = 0;
       
       for($i = 0; $i < $objArrayTrans->count(); $i) {
           #Recuperando a transação de resposta
           $transacaoResposta = $objArrayTrans->offsetGet($i)->getTransacoesTransacoes();
           
           #Verificando se ela existe
           if($transacaoResposta) {
              #Recuperando e setando o valor bruto
              $objArrayRetorno->offsetGet($contArrayRetorno, array("bruto" => $objArrayTrans->offsetGet($i)->getValorTransacoes()));              
              #Recuperando o valor Líquido
              $valorLiquido = $transacaoResposta->getValorTrocoTransacoes() ? $transacaoResposta->getValorTrocoTransacoes() : $transacaoResposta->getValorTransacoes();
              #Setando o valor Líquido
              $objArrayRetorno->offsetGet($contArrayRetorno, array("liquido" => $valorLiquido));              

              
              
              $contArrayRetorno++;
           }
       }
   }
}

