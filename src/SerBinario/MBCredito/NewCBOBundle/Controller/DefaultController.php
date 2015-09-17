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
    public function logoutAction() {
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
                return array("form" => $form->createView());
            } else {
                #Messagem de retorno
                $this->get('session')->getFlashBag()->add('danger', (string) $form->getErrors());
            }
        }

        #Retorno
        return array("form" => $form->createView());
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
            return $this->redirect($this->generateUrl("gridConsiguinacao"));
        }
        
        if(!$dataInicial || !$dataFinal) {
            $this->addFlash("warning", "Você precisa informar tanto a data inicial quanto a final");
            return $this->redirect($this->generateUrl("gridConsiguinacao"));
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

        return $this->redirect($this->generateUrl("gridTransacoes"));
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

            $resultCliente  = $gridClass->builderQuery();            
            $countTotal     = $gridClass->getCount();
            $countEventos   = count($resultCliente);
            
            for($i=0;$i < $countEventos; $i++)
            {   
                #Variaveis de somatorio
                $liquido = 0;
                $bruto   = 0;
                $canceladoLiquido = 0;
                
                #Populando o array de retorno
                $transacoesArray[$i]['DT_RowId'] = $resultCliente[$i]->getIdOperadores();    
                $transacoesArray[$i]['nome']     = $resultCliente[$i]->getNomeOperadores();
                $transacoesArray[$i]['chave']    = $resultCliente[$i]->getCodOperadores();
                
                $dateIni = isset($whereCamposPesquisa['dateIn']) ? $whereCamposPesquisa['dateIn'] : "";
                $dateFin = isset($whereCamposPesquisa['dateFin']) ? $whereCamposPesquisa['dateFin'] : "";
                
                $valorBruto          = $transacaoRN->findByOperadorBetweenDateBruto($resultCliente[$i]->getIdOperadores(), $dateIni, $dateFin);
                $valorLiquido        = $transacaoRN->findByOperadorBetweenDateLiquido($resultCliente[$i]->getIdOperadores(), $dateIni, $dateFin);
                $valorTrocoLiquido   = $transacaoRN->findByOperadorBetweenDateTrocoLiquido($resultCliente[$i]->getIdOperadores(), $dateIni, $dateFin);
                $valorCancelado      = $transacaoRN->findByOperadorBetweenDateCancelado($resultCliente[$i]->getIdOperadores(), $dateIni, $dateFin);
                $valorTrocoCancelado = $transacaoRN->findByOperadorBetweenDateTrocoCancelado($resultCliente[$i]->getIdOperadores(), $dateIni, $dateFin);
                
                #Populando o array de retorno
                $transacoesArray[$i]['bruto']   = ( (float) $valorBruto[1]) - ( (float) $valorCancelado[1] );    
                $transacoesArray[$i]['liquido'] = ( (float) $valorLiquido[1] ) + ( (float) $valorTrocoLiquido[1]);
                
            }            

            //Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()){
                $countEventos = $countTotal;
            }

            $columns = array(               
                'draw'              => $parametros['draw'],
                'recordsTotal'      => "{$countTotal}",
                'recordsFiltered'   => "{$countEventos}",
                'data'              => $transacoesArray               
            );

            return new JsonResponse($columns);
        }else{            
            return array();            
        }
        
    }
}