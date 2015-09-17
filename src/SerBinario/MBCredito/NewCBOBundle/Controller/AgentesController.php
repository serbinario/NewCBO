<?php

namespace SerBinario\MBCredito\NewCBOBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use SerBinario\MBCredito\NewCBOBundle\Util\GridClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use SerBinario\MBCredito\NewCBOBundle\Form\OperadoresType;

/**
 * Description of AgentesController
 *
 * @author serbinario
 */
class AgentesController extends Controller
{
    /**
     * 
     * @Route("/gridAgentes", name="gridAgentes")
     * @Template()
     * 
     * @param Request $request
     * @return \SerBinario\MBCredito\CBOBundle\Controller\JsonResponse
     */
    public function gridAgentesAction(Request $request)
    {
        if(GridClass::isAjax()) {
            
            $columns = array(     
                "a.codOperadores",
                "a.nomeOperadores"
                );

            $entityJOIN = array(); 

            $detalheArray     = array();
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
                    $whereFull);            
            
            
            $resultDetalhe   = $gridClass->builderQuery();        

            $countTotal           = $gridClass->getCount();            
            $countDetalhe         = count($resultDetalhe);     
                       
            for($i=0;$i < $countDetalhe; $i++)
            {       
                $detalheArray[$i]['DT_RowId']  = "row_". $i; 
                $detalheArray[$i]['chave']     =  $resultDetalhe[$i]->getCodOperadores(); 
                $detalheArray[$i]['nome']      =  $resultDetalhe[$i]->getNomeOperadores() ? $resultDetalhe[$i]->getNomeOperadores() : "NENHUM NOME CADASTRADO";                 
            }             
            
            #Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()) {
                $countDetalhe = $countTotal;
            }
           
            $columns = array(               
                'draw'              => $parametros['draw'],
                'recordsTotal'      => "{$countTotal}",
                'recordsFiltered'   => "{$countDetalhe}",
                'data'              => $detalheArray
            );       
            
            return new JsonResponse($columns);
        }else {            
            return array();            
        }
    }
    
    /**
     * 
     * @Route("/saveAgente", name="saveAgente")     
     * @Template()
     */
    public function saveAction(Request $request)
    {
        #Criando o formulário
        $form = $this->createForm(new OperadoresType());

        #Recuperando o serviço do container
        $operadoresRN = $this->get('operadores_rn');

        #Verficando se é uma submissão
        if ($request->getMethod() === "POST") {
            #Repasando a requisição
            $form->handleRequest($request);

            #Verifica se os dados são válidos
            if ($form->isValid()) {
                #Recuperando os dados
                $operadores = $form->getData();
               
                #Executando e recuperando o resultado
                $result = $operadoresRN->save($operadores);

                if ($result) {
                    #Messagem de retorno
                    $this->get('session')->getFlashBag()->add('success', 'Dados cadastrado com sucesso');
                } else {
                    #Messagem de retorno
                    $this->get('session')->getFlashBag()->add('danger', 'Erro ao cadastrado Dados');
                }

                #Criando o formulário
                $form = $this->createForm(new OperadoresType());

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
     * @Route("/update/{id}", name="updateEmissora")
     * @Template()
     */
    public function updateAction(Request $request, $id)
    {        
        #Recuperando o serviço do container
        $operadoresRN = $this->get('operadores_rn');
        $operador     = $operadoresRN->find($id);
        
        #Criando o formulário
        $form = $this->createForm(new OperadoresType(), $operador);
        
        #Verficando se é uma submissão
        if ($request->getMethod() === "POST") {
            #Repasando a requisição
            $form->handleRequest($request);

            #Verifica se os dados são válidos
            if ($form->isValid()) {
                #Recuperando os dados
                $operadores = $form->getData();
               
                #Executando e recuperando o resultado
                $result = $operadoresRN->update($operadores);

                if ($result) {
                    #Messagem de retorno
                    $this->get('session')->getFlashBag()->add('success', 'Dados cadastrado com sucesso');
                } else {
                    #Messagem de retorno
                    $this->get('session')->getFlashBag()->add('danger', 'Erro ao cadastrado Dados');
                }
                
                $operador = $operadoresRN->find($id);
                
                #Criando o formulário
                $form = $this->createForm(new OperadoresType(), $operador);

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
}
