<?php

namespace SerBinario\MBCredito\NewCBOBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SerBinario\MBCredito\NewCBOBundle\Form\ArquivoCBFType;
use SerBinario\MBCredito\NewCBOBundle\Util\ProcessamentoCBFUtil;
use Symfony\Component\HttpFoundation\Request;
use SerBinario\MBCredito\NewCBOBundle\Util\GridClass;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("viewImportFile", name="viewImportFile")
     * @Template()
     */
    public function viewImportFileAction(Request $request)
    {
        #Criando o formulário
        $form = $this->createForm(new ArquivoCBFType());
        
        #Recuperando os serviços do container
        $arquivoCBFRN        = $this->get('rn_arquivoCBF'); 
        $arquivoCabecalhoDAO = $this->get('dao_arquivoCabecalho');
        
        #Recupera os ultimos 15 arquivos 
        $arquivosCabecalhos  = $arquivoCabecalhoDAO->findLastsDesc();
        
        #Verficando se é uma submissão
        if ($request->getMethod() === "POST") {
            #Repasando a requisição
            $form->handleRequest($request);

            #Verifica se os dados são válidos
            if ($form->isValid()) {
                #Recuperando os dados
                $arquivoCBF = $form->getData();
                
                #Recuperando o arquivo
                $path = __DIR__.'/../../../../../web/upload/files/'. $arquivoCBF->getImageName();
                
                #Verificando se o arquivo já existe
                if($arquivoCBFRN->findByName($arquivoCBF->getImageFile()->getClientOriginalName())) {
                    $this->get('session')->getFlashBag()->add('danger', "Arquivo já foi importado!");
                    
                    #Retorno
                    return array("form" => $form->createView(), "arquivos" => $arquivosCabecalhos);
                }
               
                #Executando e recuperando o resultado
                $resultUpload = $arquivoCBFRN->save($arquivoCBF); 
                
                #Verifica se a o upload foi realizado com sucesso
                if(!$resultUpload) {
                    $this->get('session')->getFlashBag()->add('danger', "Erro ao importar o arquivo!");
                    
                    #Retorno
                    return array("form" => $form->createView(), "arquivos" => $arquivosCabecalhos);
                } 
                
                #Processamento do arquivo, montando à arvore de objetos.
                $arquivoCabecalho = ProcessamentoCBFUtil::processar($resultUpload->getImageName());
                $arquivoCabecalho->setArquivoCBF($resultUpload);
                
                #Recuperando os serviços do container
                $CBFRN  = $this->get('rn_CBF');
                $result = $CBFRN->salvar($arquivoCabecalho);
                
                #Recupera os ultimos 15 arquivos 
                $arquivosCabecalhos  = $arquivoCabecalhoDAO->findLastsDesc();
                
                #Verificando a resposta
                if(!$result) {
                    #Mensagem de erro
                    $this->get('session')->getFlashBag()->add('danger', "Erro ao importar o arquivo!");
                } else {
                    #Mensagem de sucesso
                    $this->get('session')->getFlashBag()->add('success', "Arquivo importado com sucesso!");
                }
                
                #Criando o formulário
                $form = $this->createForm(new ArquivoCBFType());

                #Retorno
                return array("form" => $form->createView(), "arquivos" => $arquivosCabecalhos);
            } else {
                #Messagem de retorno
                $this->get('session')->getFlashBag()->add('danger', (string) $form->getErrors());
            }
        }

        #Retorno
        return array("form" => $form->createView(), "arquivos" => $arquivosCabecalhos);
    }
    
    /**
     * @Route("/delete/{id}", name="deleteCBO")
     */
    public function delete($id)
    {
        $manager = $this->getDoctrine()->getManager();
        $entity  = $manager->find("NewCBOBundle:ArquivoCabecalho", $id);
        
        $manager->remove($entity);
        $manager->flush();
        
        #Mensagem de sucesso
        $this->get('session')->getFlashBag()->add('success', "Arquivo deletado com sucesso!"); 
        
        #Retorno
        return $this->redirectToRoute("viewImportFile");
    }
    
    /**
     * 
     * @Route("/processamentoCamposPesquisaCBO", name="processamentoCamposPesquisaCBO")
     */
    public function processamentoCamposPesquisaCBOAction(Request $request) {
        
        $dados = $request->request->all();

        $dataInicial = $dados["dataInicial"];
        $dataFinal   = $dados["dataFinal"];
        
        if(!$dataInicial && !$dataFinal) {
            $this->get("session")->set("camposPesquisaCBO", null);
            return $this->redirectToRoute("gridTransacoes");
        }
        
        if(!$dataInicial || !$dataFinal) {
            $this->addFlash("warning", "Você precisa informar tanto a data inicial quanto a final");
            return $this->redirectToRoute("gridTransacoes");
        }
        
        if (!empty($dataInicial)) {
            $dataInicial = implode("-", array_reverse(explode("/", $dataInicial)));
            $dataInicial = \DateTime::createFromFormat("Y-m-d", $dataInicial);  
            $dataInicial->setTime(0,0,0);
        }

        if (!empty($dataFinal)) {
            $dataFinal = implode("-", array_reverse(explode("/", $dataFinal)));
            $dataFinal = \DateTime::createFromFormat("Y-m-d", $dataFinal);
            $dataFinal->setTime(0,0,0);
        }

        $camposPesquisa = array(
            "periodo" => [$dataInicial, $dataFinal],
        );

        $this->get("session")->set("camposPesquisaCBO", $camposPesquisa);

        return $this->redirectToRoute("gridTransacoes");
    }
    
    
    /**
     * @Route("gridTransacoes", name="gridTransacoes")
     * @Template()
     */
    public function gridTransacoesAction(Request $request)
    {
        #Recuperando o serviço de transação
        $transacaoRN = $this->get("rn_transacoes");
        
        if(GridClass::isAjax()) {
            
            $columns = array(
               "a.nomeOperadores",
               "a.codOperadores"               
                );
            
            $camposPesquisaCBO   = $this->get("session")->get("camposPesquisaCBO");
            $whereCamposPesquisa = array();
            
            if (!is_null($camposPesquisaCBO)) {
                foreach ($camposPesquisaCBO as $chave => $valor) {
                    if (!empty($valor)) {
                        if ($chave === "periodo") {
                            $whereCamposPesquisa['dataIn'] = $valor[0];
                            $whereCamposPesquisa['dataFi'] = $valor[1];                      
                        }
                    }
                }
            } else {
                $whereCamposPesquisa['dataIn'] = new \DateTime("now");
                $whereCamposPesquisa['dataFi'] = new \DateTime("now");
            }

            $entityJOIN       = array();             
            $transacoesArray  = array();
            $parametros       = $request->request->all();       
            $entity           = "SerBinario\MBCredito\NewCBOBundle\Entity\Operadores"; 
            $columnWhereMain  = "";
            $whereValueMain   = "";            
            $whereFull        = " a.statusOperadores = true" ;
            
            $gridClass = new GridClass($this->getDoctrine()->getManager(), 
                    $parametros,
                    $columns,
                    $entity,
                    $entityJOIN,           
                    $columnWhereMain,
                    $whereValueMain,
                    $whereFull
                    );            
         
            $resultCliente   = $gridClass->builderQuery();            
            $countTotal      = $gridClass->getCountByWhereFull(array(), array(), $whereFull);
            $countEventos    = count($resultCliente);          
            
            #Variáveis de soma global
            $valorTotalBruto     = 0.0;
            $valorTotalLiquido   = 0.0;
            $valorTotalPeBruto   = 0.0;
            $valorTotalPeLiquido = 0.0;
            $valorTotalAlBruto   = 0.0;
            $valorTotalAlLiquido = 0.0;
            $valorTotalBaBruto   = 0.0;
            $valorTotalBaLiquido = 0.0;
            $valorTotalMgBruto   = 0.0;
            $valorTotalMgLiquido = 0.0;
           
            for($i=0;$i < $countEventos; $i++)
            {          
                #Variáveis de soma local
                $totalLiquido     = 0.0;
                $totalBruto       = 0.0;
                $canceladoLiquido = 0.0;         
                
                #Recuperando o id do operador e alimentando o array
                $OperadoresId[$i] = $resultCliente[$i]->getIdOperadores();
                
                #Populando o array de retorno
                $transacoesArray[$i]['DT_RowId'] = "row_".$resultCliente[$i]->getIdOperadores();    
                $transacoesArray[$i]['nome']     = $resultCliente[$i]->getNomeOperadores();
                $transacoesArray[$i]['chave']    = $resultCliente[$i]->getCodOperadores();
         
                $transacoes = $transacaoRN->findByCodTransacao("068", $resultCliente[$i]->getIdOperadores(), $whereCamposPesquisa);

                foreach ($transacoes as $respotaliquida) {
                    $transacao = $transacaoRN->findByCodOperacao($respotaliquida->getNumeroPropostaTransacoes(), "065");

                    if($respotaliquida) {
                        $valorLiquido  = $respotaliquida->getValorTrocoTransacoes() != 0 ? $respotaliquida->getValorTrocoTransacoes() : $respotaliquida->getValorTransacoes();
                        $valorBruto    = $transacao->getValorTransacoes();
                        $totalLiquido += $valorLiquido;
                        $totalBruto   += $valorBruto;

                        # Contando por estados
                        switch($respotaliquida->getlojasLojas()->getCodigoLojas()) {
                            case 1000 : $valorTotalPeBruto += $valorBruto; $valorTotalPeLiquido += $valorLiquido;break;
                            case 1001 : $valorTotalAlBruto += $valorBruto; $valorTotalAlLiquido += $valorLiquido;break;
                            case 1002 : $valorTotalBaBruto += $valorBruto; $valorTotalBaLiquido += $valorLiquido;break;
                            case 1003 : $valorTotalAlBruto += $valorBruto; $valorTotalAlLiquido += $valorLiquido;break;
                        }
                    }
                }
                
                #Totais Gerais
                $valorTotalBruto   += $totalBruto;
                $valorTotalLiquido += $totalLiquido;
                
                #Populando o array de retorno
                $transacoesArray[$i]['bruto']   = $totalBruto;
                $transacoesArray[$i]['liquido'] = $totalLiquido;                
            }
            
            #Ordenando o array de retorno
            $objArray = new \ArrayObject($transacoesArray);
            $objArray->uasort(function($valorUm, $valorDois) {
                if ($valorUm['liquido'] == $valorDois['liquido']) {
                    return 0;
                }
                
                return ($valorUm['liquido'] > $valorDois['liquido']) ? -1 : 1;
            });
          
            #Polulando o array ordenado
            $count = 0;
            foreach($objArray->getIterator() as $obj) {
                $transacoesArray[$count] = $obj;
                $transacoesArray[$count]['bruto'] = number_format($transacoesArray[$count]['bruto'], 2, ',', '.');
                $transacoesArray[$count]['liquido'] = number_format($transacoesArray[$count]['liquido'], 2, ',', '.');
                $count++;
            }            
            
            //Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()){
                $countEventos = $countTotal;
            }
            
            $columns = array(               
                'draw'              => $parametros['draw'],
                'recordsTotal'      => "{$countTotal}",
                'recordsFiltered'   => "{$countEventos}",
                'data'              => $transacoesArray,
                'somatorios'        =>array(
                  "somaTotalBruto"   => number_format($valorTotalBruto, 2, ',', '.'),
                  "somaTotalLiquido" => number_format($valorTotalLiquido, 2, ',', '.'),
                  "somaPeBruto"      => number_format($valorTotalPeBruto, 2, ',', '.'),
                  "somaPeLiquido"    => number_format($valorTotalPeLiquido, 2, ',', '.'),
                  "somaAlBruto"      => number_format($valorTotalAlBruto, 2, ',', '.'),
                  "somaAlLiquido"    => number_format($valorTotalAlLiquido, 2, ',', '.'),
                  "somaBaBruto"      => number_format($valorTotalBaBruto, 2, ',', '.'),
                  "somaBaLiquido"    => number_format($valorTotalBaLiquido, 2, ',', '.'),
                  "somaMgBruto"      => number_format($valorTotalMgBruto, 2, ',', '.'),
                  "somaMgLiquido"    => number_format($valorTotalMgLiquido, 2, ',', '.')                    
               )
            );

            return new JsonResponse($columns);
        }else{            
            return array();            
        }
        
    }
}
