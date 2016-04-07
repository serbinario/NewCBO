<?php

namespace SerBinario\MBCredito\NewCBOBundle\Util;

use SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCabecalhoCBG;
use SerBinario\MBCredito\NewCBOBundle\Entity\TransacoesCBG;

class ProcessamentoCBGUtil
{
    /**
     *
     * @param type $fileName
     * @return ArquivoCabecalhoCBG
     * @throws \InvalidArgumentException
     */
    public static function processar($fileName)
    {
        #Variável de escopo
        $arquivoCabecalhoCBG  = new ArquivoCabecalhoCBG();

        #caminho do arquivo
        $path = __DIR__.'/../../../../../web/upload/files/'.$fileName;

        #Recuperando as linhas do arquivo como array
        #e transformando em um objeto array
        $linesObject = new \ArrayObject(\file($path));

        #Varredura do $linesObject e 
        #criação do array de Objetos de Arquivo
        for($i = 0; $i < $linesObject->count(); $i++) {
            #Variáveis de armazenamento dos objetos           
            $transacoesCBG       = new TransacoesCBG();
            #Recuperando a próxima linha
            $line             = $linesObject->offsetGet($i);
            #Recuperando o tipo da linha
            $typeLine         = \substr($line, 0, 1);

            #Tratamento do cabeçalho do arquivo
            if($typeLine == 0) {
                $arquivoCabecalhoCBG->setBanco(substr($line, 1, 3));
                $arquivoCabecalhoCBG->setData(\DateTime::createFromFormat('Y/m/d', substr($line, 4,4) . "/" . substr($line, 8,2) . "/" .substr($line, 10,2)));
                $arquivoCabecalhoCBG->setNome(substr($line, 12, 8));
                $arquivoCabecalhoCBG->setSigla(substr($line, 20,3));
                $arquivoCabecalhoCBG->setCodigoMCI(substr($line, 23,9));
                $arquivoCabecalhoCBG->setNumeroContrato(substr($line, 32,9));
            }

            #Tratamento das transações
            if($typeLine == 1) {
                
                #Adicionando a transação ao objeto do arquivo
                $arquivoCabecalhoCBG->addTransacoesCBG($transacoesCBG);
            }            
        }

        #Retorno
        return $arquivoCabecalhoCBG;
    }
}