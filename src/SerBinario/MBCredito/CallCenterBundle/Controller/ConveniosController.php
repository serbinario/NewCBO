<?php
namespace SerBinario\MBCredito\CallCenterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use SerBinario\MBCredito\CallCenterBundle\UTIL\GridClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use SerBinario\MBCredito\CallCenterBundle\Form\ConveniosType;

/**
 * Description of ConveniosController
 * 
 * @author serbinario
 */
class ConveniosController extends Controller 
{
    /**
     * 
     * @Route("/gridConvenios", name="gridConvenios")
     * @Template()
     */
    public function gridConveniosAction(Request $request)
    {
        if(GridClass::isAjax()) {
            
            $columns = array(
                "a.convenio"
                );

            $entityJOIN = array();             
            $agenciasArray        = array();
            $parametros           = $request->request->all();
            $entity               = "SerBinario\MBCredito\CallCenterBundle\Entity\Convenios"; 
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
                $agenciasArray[$i]['nomeConvenio']  = $resultAgencias[$i]->getConvenio();
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
     * @Route("/saveConvenio", name="saveConvenio")
     * @Template()
     */
    public function saveConvenioAction(Request $request)
    {        
        #Criando o formulário
        $form    = $this->createForm(new ConveniosType());
        
        #Recuperando o serviço do container
        $convenioRN = $this->get('rn_convenio');
        
         #Verficando se é uma submissão
        if($request->getMethod() === "POST") {
            #Repasando a requisição
            $form->handleRequest($request);
            
            #Verifica se os dados são válidos
            if($form->isValid()) {
                #Recuperando os dados
                $convenio = $form->getData();
                
                #Executando e recuperando o resultado
                $result = $convenioRN->save($convenio);
                
                if($result) {
                    #Messagem de retorno
                    $this->get('session')->getFlashBag()->add('success', 'Convênio cadastrado com sucesso'); 
                } else {
                    #Messagem de retorno
                    $this->get('session')->getFlashBag()->add('danger', 'Erro ao cadastrado Convênio');
                }                
                
                #Criando o formulário
                $form = $this->createForm(new ConveniosType());
               
                #Retorno
                //return array("form" => $form->createView());
                return $this->redirectToRoute("gridConvenios");
            } else {
                #Messagem de retorno
                $this->get('session')->getFlashBag()->add('danger', (string) $form->getErrors());
            }       
            
        }
        
        #Retorno
        return array("form" => $form->createView());
    }
    
    /**
     * @Route("/update/{id}", name="updateConvenio")
     * @Template()
     */
    public function updateConvenioAction(Request $request, $id)
    {        
        #Recuperando o serviço do container
        $convenioRN = $this->get('rn_convenio');
        $convenio     = $convenioRN->find($id);
        
        #Criando o formulário
        $form = $this->createForm(new ConveniosType(), $convenio);
        
        #Verficando se é uma submissão
        if ($request->getMethod() === "POST") {
            #Repasando a requisição
            $form->handleRequest($request);

            #Verifica se os dados são válidos
            if ($form->isValid()) {
                #Recuperando os dados
                $convenio = $form->getData();
               
                #Executando e recuperando o resultado
                $result = $convenioRN->update($convenio);

                if ($result) {
                    #Messagem de retorno
                    $this->get('session')->getFlashBag()->add('success', 'Dados cadastrado com sucesso');
                } else {
                    #Messagem de retorno
                    $this->get('session')->getFlashBag()->add('danger', 'Erro ao cadastrado Dados');
                }
                
                $convenio = $convenioRN->find($id);
                
                #Criando o formulário
                $form = $this->createForm(new ConveniosType(), $convenio);

                #Retorno
                //return array("form" => $form->createView());
                return $this->redirectToRoute("gridConvenios");
            } else {
                #Messagem de retorno
                $this->get('session')->getFlashBag()->add('danger', (string) $form->getErrors());
            }
        }

        #Retorno
        return array("form" => $form->createView());
    }

}
