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
     * @Route("/", name="login")
     * @Template()
     */
    public function loginAction()
    {
        return array();
    }
    
    /**
     * @Route("/logar", name="logar")
     * @Template()
     */
    public function logarAction(Request $request)
    {
        $dados = $request->request->all();
        
        $login = $dados['username'];
        $senha = $dados['password'];
        
        if($login == "mbcredito" && $senha == "mbcredito") {
            return $this->redirect($this->generateUrl("gridTransacoes"));
        } else {
            $this->addFlash("danger", "login ou senha inválidos");
        }
        
        return $this->redirect($this->generateUrl("login"));
    }
    
    /**
     * @Route("/logout", name="logout")
     * @Template()
     */
    public function logoutAction() 
    {
        return $this->redirect($this->generateUrl("login"));
    }
    
    
    /**
     * @Route("viewImportFile", name="viewImportFile")
     * @Template("")
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
                if($arquivoCBFRN->findByName($arquivoCBF->getImageName())) {
                    $this->get('session')->getFlashBag()->add('danger', "Arquivo já foi importado!");
                }
               
                #Executando e recuperando o resultado
                $resultUpload = $arquivoCBFRN->save($arquivoCBF); 
                
                #Verifica se a o upload foi realizado com sucesso
                if(!$resultUpload) {
                    $this->get('session')->getFlashBag()->add('danger', "Erro ao importar o arquivo!");
                    
                    #Retorno
                    return array("form" => $form->createView());
                } 
                
                #Processamento do arquivo, montando à arvore de objetos.
                $arquivoCabecalho = ProcessamentoCBFUtil::processar($resultUpload->getImageName());
                $arquivoCabecalho->setArquivoCBF($resultUpload);
                
                #Recuperando os serviços do container
                $CBFRN  = $this->get('rn_CBF');
                $result = $CBFRN->salvar($arquivoCabecalho);
                
                #Verificando a resposta
                if(!$result) {
                    $this->get('session')->getFlashBag()->add('danger', "Erro ao importar o arquivo!");
                }
                
                #Mensagem de sucesso
                $this->get('session')->getFlashBag()->add('success', "Arquivo importado com sucesso!");
                
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
        }

        if (!empty($dataFinal)) {
            $dataFinal = implode("-", array_reverse(explode("/", $dataFinal)));
            $dataFinal = \DateTime::createFromFormat("Y-m-d", $dataFinal);
        }

        $camposPesquisa = array(
            "periodo" => [$dataInicial, $dataFinal],
        );

        $this->get("session")->set("camposPesquisaCBO", $camposPesquisa);

        return $this->redirectToRoute("gridTransacoes");
    }
    
    
    /**
     * @Route("gridTransacoes", name="gridTransacoes")
     * @Template("")
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
                            $whereCamposPesquisa['dateIn']  = $valor[0]->format("Y-m-d");
                            $whereCamposPesquisa['dateFin'] = $valor[1]->format("Y-m-d");                        
                        }
                    }
                }
            }

            $entityJOIN       = array();             
            $transacoesArray  = array();
            $parametros       = $request->request->all();       
            $entity           = "SerBinario\MBCredito\NewCBOBundle\Entity\Operadores"; 
            $columnWhereMain  = "";
            $whereValueMain   = "";
            $whereFull        = "";
            
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
            $countTotal      = $gridClass->getCount();
            $countEventos    = count($resultCliente);        
            $OperadoresId    = array();
            $valorTotalBru   = 0;
            $valorTotalLiq   = 0;
            
            for($i=0;$i < $countEventos; $i++)
            {   
                #Variaveis de somatorio
                $liquido = 0;
                $bruto   = 0;
                $canceladoLiquido = 0;
                
                #Recuperando o id do operador e alimentando o array
                $OperadoresId[$i] = $resultCliente[$i]->getIdOperadores();
                
                #Populando o array de retorno
                $transacoesArray[$i]['DT_RowId'] = $resultCliente[$i]->getIdOperadores();    
                $transacoesArray[$i]['nome']     = $resultCliente[$i]->getNomeOperadores();
                $transacoesArray[$i]['chave']    = $resultCliente[$i]->getCodOperadores();
                
                $dateIni = isset($whereCamposPesquisa['dateIn'])  ? $whereCamposPesquisa['dateIn']  : "";
                $dateFin = isset($whereCamposPesquisa['dateFin']) ? $whereCamposPesquisa['dateFin'] : "";
                
                $valorBruto          = $transacaoRN->findByOperadorBetweenDateBruto($resultCliente[$i]->getIdOperadores(), $dateIni, $dateFin);
                $valorLiquido        = $transacaoRN->findByOperadorBetweenDateLiquido($resultCliente[$i]->getIdOperadores(), $dateIni, $dateFin);
                $valorTrocoLiquido   = $transacaoRN->findByOperadorBetweenDateTrocoLiquido($resultCliente[$i]->getIdOperadores(), $dateIni, $dateFin);
                $valorCancelado      = $transacaoRN->findByOperadorBetweenDateCancelado($resultCliente[$i]->getIdOperadores(), $dateIni, $dateFin);
                $valorTrocoCancelado = $transacaoRN->findByOperadorBetweenDateTrocoCancelado($resultCliente[$i]->getIdOperadores(), $dateIni, $dateFin);
                
                #Populando o array de retorno
                $transacoesArray[$i]['bruto']   = number_format($valorBruto[1], 2, ',', '.'); 
                $transacoesArray[$i]['liquido'] = number_format(( (float) $valorLiquido[1] ) + ( (float) $valorTrocoLiquido[1]), 2, ',', '.');;
                
            }   
            
            #Totais Gerais
            $valorTotalBru   = $transacaoRN->findTotalDateBruto($dateIni, $dateFin);
            $valorTotalLiq   = $transacaoRN->findTotalDateLiquido($dateIni, $dateFin);
            $valorTotalTro   = $transacaoRN->findTotalnDateTrocoLiquido($dateIni, $dateFin);
            
            #Totais liquidos e brutos dos estados
            $valorTotalBruPe = $transacaoRN->findByOperadoresByEstadoBetweenDateBruto(1000, $dateIni, $dateFin);
            $valorTotalLiqPe = $transacaoRN->findByOperadoresByEstadoBetweenDateLiquido(1000, $dateIni, $dateFin);
            $valorTotalTroPe = $transacaoRN->findByOperadoresByEstadoBetweenDateTrocoLiquido(1000, $dateIni, $dateFin);
            
            #Totais liquidos e brutos dos estados
            $valorTotalBruBa = $transacaoRN->findByOperadoresByEstadoBetweenDateBruto(1002, $dateIni, $dateFin);            
            $valorTotalLiqBa = $transacaoRN->findByOperadoresByEstadoBetweenDateLiquido(1002, $dateIni, $dateFin);
            $valorTotalTroBa = $transacaoRN->findByOperadoresByEstadoBetweenDateTrocoLiquido(1002, $dateIni, $dateFin);
            
            #Totais liquidos e brutos dos estados
            $valorTotalBruMg = $transacaoRN->findByOperadoresByEstadoBetweenDateBruto(1003, $dateIni, $dateFin);
            $valorTotalLiqMg = $transacaoRN->findByOperadoresByEstadoBetweenDateLiquido(1003, $dateIni, $dateFin);
            $valorTotalTroMg = $transacaoRN->findByOperadoresByEstadoBetweenDateTrocoLiquido(1003, $dateIni, $dateFin);
            
            #Totais liquidos e brutos dos estados
            $valorTotalBruAl = $transacaoRN->findByOperadoresByEstadoBetweenDateBruto(1001, $dateIni, $dateFin);
            $valorTotalLiqAL = $transacaoRN->findByOperadoresByEstadoBetweenDateLiquido(1001, $dateIni, $dateFin);
            $valorTotalTroAl = $transacaoRN->findByOperadoresByEstadoBetweenDateTrocoLiquido(1001, $dateIni, $dateFin);
           //var_dump($valorTotalBruPe);exit;
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
                    "somaTotalBruto"   => number_format($valorTotalBru[1], 2, ',', ' '),
                    "somaTotalLiquido" => number_format($valorTotalLiq[1] + $valorTotalTro[1], 2, ',', ' '),
                    "somaPeBruto"      => number_format($valorTotalBruPe[1], 2, ',', ' '),
                    "somaPeLiquido"    => number_format($valorTotalLiqPe[1] + $valorTotalTroPe[1], 2, ',', ' '),
                    "somaAlBruto"      => number_format($valorTotalBruAl[1], 2, ',', ' '),
                    "somaAlLiquido"    => number_format($valorTotalLiqAL[1] + $valorTotalTroAl[1], 2, ',', ' '),
                    "somaBaBruto"      => number_format($valorTotalBruBa[1], 2, ',', ' '),
                    "somaBaLiquido"    => number_format($valorTotalLiqBa[1] + $valorTotalTroBa[1], 2, ',', ' '),
                    "somaMgBruto"      => number_format($valorTotalBruMg[1], 2, ',', ' '),
                    "somaMgLiquido"    => number_format($valorTotalLiqMg[1] + $valorTotalTroMg[1], 2, ',', ' ')                    
                )
            );

            return new JsonResponse($columns);
        }else{            
            return array();            
        }
        
    }
}