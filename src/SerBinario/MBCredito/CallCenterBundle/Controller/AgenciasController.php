<?php
namespace SerBinario\MBCredito\CallCenterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use SerBinario\MBCredito\CallCenterBundle\UTIL\GridClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use SerBinario\MBCredito\CallCenterBundle\Form\AgenciasType;

class AgenciasController extends Controller
{
    
    /**
     * 
     * @Route("/gridAgencias", name="gridAgencias")
     * @Template()
     */
    public function gridAgenciasAction(Request $request)
    {
        if(GridClass::isAjax()) {
            
            $columns = array(
                "a.numeroAgencia",
                "a.nomeAgencia"
                );

            $entityJOIN = array();             
            $agenciasArray        = array();
            $parametros           = $request->request->all();
            $entity               = "SerBinario\MBCredito\CallCenterBundle\Entity\Agencias"; 
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

            $resultAgencias = $gridClass->builderQuery();    
            $countTotal     = $gridClass->getCount();
            $countEventos   = count($resultAgencias);

            for($i=0;$i < $countEventos; $i++)
            {                
                $agenciasArray[$i]['DT_RowId']      = "row_".$resultAgencias[$i]->getId();
                $agenciasArray[$i]['id']            = $resultAgencias[$i]->getId();
                $agenciasArray[$i]['numeroAgencia'] = $resultAgencias[$i]->getNumeroAgencia();
                $agenciasArray[$i]['nomeAgencia']   = $resultAgencias[$i]->getNomeAgencia();                
            }

            //Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()){
                $countEventos = $countTotal;
            }

            $columns = array(               
                'draw'              => $parametros['draw'],
                'recordsTotal'      => "{$countTotal}",
                'recordsFiltered'   => "{$countEventos}",
                'data'              => $agenciasArray               
            );

            return new JsonResponse($columns);
        }else{            
            return array();            
        }
    }
    
    /**
     * @Route("/saveAgencia", name="saveAgencia")
     * @Template()
     */
    public function saveAgenciaAction(Request $request)
    {        
        #Criando o formulário
        $form    = $this->createForm(new AgenciasType());
        
        #Recuperando o serviço do container
        $agenciaRN = $this->get('rn_agencia');
        
         #Verficando se é uma submissão
        if($request->getMethod() === "POST") {
            #Repasando a requisição
            $form->handleRequest($request);
            
            #Verifica se os dados são válidos
            if($form->isValid()) {
                #Recuperando os dados
                $agencia = $form->getData();
                
                #Executando e recuperando o resultado
                $result = $agenciaRN->save($agencia);
                
                if($result) {
                    #Messagem de retorno
                    $this->get('session')->getFlashBag()->add('success', 'Médico cadastrado com sucesso'); 
                } else {
                    #Messagem de retorno
                    $this->get('session')->getFlashBag()->add('danger', 'Erro ao cadastrado médico');
                }                
                
                #Criando o formulário
                $form = $this->createForm(new AgenciasType());
               
                #Retorno
                //return array("form" => $form->createView());
                return $this->redirectToRoute("gridAgencias");
            } else {
                #Messagem de retorno
                $this->get('session')->getFlashBag()->add('danger', (string) $form->getErrors());
            }       
            
        }
        
        #Retorno
        return array("form" => $form->createView());
    }
    
    /**
     * @Route("/update/{id}", name="updateAgencias")
     * @Template()
     */
    public function updateAgenciasAction(Request $request, $id)
    {        
        #Recuperando o serviço do container
        $agenciaRN = $this->get('rn_agencia');
        $operador  = $agenciaRN->find($id);
        
        #Criando o formulário
        $form = $this->createForm(new AgenciasType(), $operador);
        
        #Verficando se é uma submissão
        if ($request->getMethod() === "POST") {
            #Repasando a requisição
            $form->handleRequest($request);

            #Verifica se os dados são válidos
            if ($form->isValid()) {
                #Recuperando os dados
                $agencia = $form->getData();
               
                #Executando e recuperando o resultado
                $result = $agenciaRN->update($agencia);

                if ($result) {
                    #Messagem de retorno
                    $this->get('session')->getFlashBag()->add('success', 'Dados cadastrado com sucesso');
                } else {
                    #Messagem de retorno
                    $this->get('session')->getFlashBag()->add('danger', 'Erro ao cadastrado Dados');
                }
                
                $operador = $agenciaRN->find($id);
                
                #Criando o formulário
                $form = $this->createForm(new AgenciasType(), $operador);

                #Retorno
                //return array("form" => $form->createView());
                return $this->redirectToRoute("gridAgencias");
            } else {
                #Messagem de retorno
                $this->get('session')->getFlashBag()->add('danger', (string) $form->getErrors());
            }
        }

        #Retorno
        return array("form" => $form->createView());
    }
    
}
