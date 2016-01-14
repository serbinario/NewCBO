<?php

namespace SerBinario\MBCredito\CallCenterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use SerBinario\MBCredito\CallCenterBundle\UTIL\GridClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use SerBinario\MBCredito\CallCenterBundle\Form\ClientesType;

class DefaultController extends Controller
{
    /**
     * 
     * @Route("/gridChamadas", name="gridChamadas")
     * @Template()
     */
    public function gridChamadasAction(Request $request)
    {
        if(GridClass::isAjax()) {
            
            $columns = array(
                "a.nome",
                "a.cpf",
                "a.conta",
                "a.agencia"
                );

            $entityJOIN = array();             
            $chamadasArray        = array();
            $parametros           = $request->request->all();
            $entity               = "SerBinario\MBCredito\CallCenterBundle\Entity\Clientes"; 
            $columnWhereMain      = "";
            $whereValueMain       = "";
            $whereFull            = "";
            
            $gridClass = new GridClass($this->getDoctrine()->getManager(), 
                    $parametros,
                    $columns,
                    $entity,
                    $entityJOIN,           
                    $columnWhereMain,
                    $whereValueMain,
                    $whereFull);

            $resultCliente  = $gridClass->builderQuery();    
            $countTotal     = $gridClass->getCount();
            $countEventos   = count($resultCliente);

            for($i=0;$i < $countEventos; $i++)
            {                
                $chamadasArray[$i]['DT_RowId'] = "row_".$resultCliente[$i]->getId();
                $chamadasArray[$i]['id']       = $resultCliente[$i]->getId();
                $chamadasArray[$i]['nome']     = $resultCliente[$i]->getNome();
                $chamadasArray[$i]['cpf']      = $resultCliente[$i]->getCpf();
                $chamadasArray[$i]['conta']    = $resultCliente[$i]->getConta();
                $chamadasArray[$i]['agencia']  = $resultCliente[$i]->getAgencia()->getNumeroAgencia();                                
                
                $chamadas      = $resultCliente[$i]->getChamadas()->toArray();             
                $arrayChamadas = array();
                $contador      = 0;
                
                foreach($chamadas as $chamada) {                    
                    $arrayChamadas[$contador]['prazo']            = $chamada->getPrazo();
                    $arrayChamadas[$contador]['valorContratado']  = "R$ " . number_format($chamada->getValorContratado(), 2, ',', '.');
                    $arrayChamadas[$contador]['dataContratacao']  = $chamada->getDataContratado()->format("d/m/Y");
                    $arrayChamadas[$contador]['tipoContratacao']  = $chamada->getTipoContrato()->getTipoContrato();
                    
                    $contador++;
                }
                
                $chamadasArray[$i]['chamadas']  = $arrayChamadas;
            }

            //Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()){
                $countEventos = $countTotal;
            }

            $columns = array(               
                'draw'              => $parametros['draw'],
                'recordsTotal'      => "{$countTotal}",
                'recordsFiltered'   => "{$countEventos}",
                'data'              => $chamadasArray               
            );

            return new JsonResponse($columns);
        }else{            
            return array();            
        }
    }
    
     /**
     * @Route("/saveCliente", name="saveCliente")
     * @Template()
     */
    public function saveClientesAction(Request $request)
    {
        #Recuperando o serviço do modelo
        $clienteRN = $this->get("rn_clientes");
        
        #Criando o formulário
        $form = $this->createForm(new ClientesType());
        
        #Verficando se é uma submissão
        if($request->getMethod() === "POST") {
            #Repasando a requisição
            $form->handleRequest($request);

            #Verifica se os dados são válidos
            if($form->isValid()) {
                #Recuperando os dados
                $cliente = $form->getData();
                
                #Recuoerando a chamada
                $chamada = $cliente->getChamadas();

                #Tratando o valor
                $valor      = str_replace(".", "", $chamada->getValorContratado());
                $valorFinal = str_replace(",", ".", $valor);
                $chamada->setValorContratado($valorFinal);

                #Trasnformando em um array collection
                $cliente->setChamadas(new \Doctrine\Common\Collections\ArrayCollection());                
                $cliente->addChamada($chamada);            
               
                #Resultado da operação
                $result =  $clienteRN->save($cliente);
                
                if($result) {
                    #Messagem de retorno
                    $this->addFlash('success', 'Cliente cadastrado com sucesso!');
                } else {
                    $this->addFlash('danger', 'Houve um erro ao cadastrar o Cliente, tente novamente!');
                }
                
                #Zerando a coleção de chamadas
                //$cliente->setChamadas(new \SerBinario\MBCredito\CallCenterBundle\Entity\Chamadas());
                
                #Criando o formulário
                //$form = $this->createForm(new ClientesType());
               
                #Retorno
                //return array("form" => $form->createView());
                #Retorno
                return  $this->redirectToRoute('gridChamadas');
            } else {
                $this->addFlash('warning', 'Há campos obrigatório que não foram preenchidos');
            }
        }
        
        #Retorno
        return array("form" => $form->createView());
    }
    
    /**
     * @Route("/newChamada/id/{id}", name="newChamada")
     * @Template()
     */
    public function newChamadaAction($id, Request $request)
    {
        #Recuperando o serviço do modelo
        $clienteRN = $this->get("rn_clientes");
        
        #Recuperando o cliente
        $cliente   = $clienteRN->find($id);
        $cliente->setChamadas(new \SerBinario\MBCredito\CallCenterBundle\Entity\Chamadas());
        
       
        #Criando o formulário
        $form = $this->createForm(new ClientesType(), $cliente);
        
        #Verficando se é uma submissão
        if($request->getMethod() === "POST") {
            #Repasando a requisição
            $form->handleRequest($request);

            #Verifica se os dados são válidos
            if($form->isValid()) {
                #Recuperando os dados
                $cliente = $form->getData();               
                
                #Recuoerando a chamada
                $chamada = $cliente->getChamadas();

                //Adicionando telefones
                $idTelefones = array();
                foreach ($cliente->getTelefones() as $telefone) {
                    $idTelefones[] = $telefone->getId();
                    $telefone->setCliente($cliente);
                }
                
                //Deletenado os telefones 
                $clienteRN->deleteTelefones($idTelefones, $cliente);
                
                #Tratando o valor
                $valor      = str_replace(".", "", $chamada->getValorContratado());
                $valorFinal = str_replace(",", ".", $valor);
                $chamada->setValorContratado($valorFinal);
                
                #Trasnformando em um array collection
                $cliente->setChamadas(new \Doctrine\Common\Collections\ArrayCollection());                
                $cliente->addChamada($chamada);       
               
                #Resultado da operação
                $result =  $clienteRN->update($cliente);
                
                if($result) {
                    #Messagem de retorno
                    $this->addFlash('success', 'Chamada cadastrada com sucesso!');
                } else {
                    $this->addFlash('danger', 'Houve um erro ao cadastrar a Chamada, tente novamente!');
                }
                
                #Zerando a coleção de chamadas
                //$cliente->setChamadas(new \SerBinario\MBCredito\CallCenterBundle\Entity\Chamadas());
                
                #Criando o formulário
                //$form = $this->createForm(new ClientesType(), $cliente);
               
                #Retorno
                return  $this->redirectToRoute('gridChamadas');
            } else {
                $this->addFlash('warning', 'Há campos obrigatório que não foram preenchidos');
            }
        }
        
        #Retorno
        return array("form" => $form->createView());
    }
}