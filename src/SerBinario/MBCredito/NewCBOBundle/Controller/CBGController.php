<?php

namespace SerBinario\MBCredito\NewCBOBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SerBinario\MBCredito\NewCBOBundle\Form\ArquivoCBGType;
use Symfony\Component\HttpFoundation\Request;
use SerBinario\MBCredito\NewCBOBundle\Util\GridClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use SerBinario\MBCredito\NewCBOBundle\Util\ProcessamentoCBGUtil;

class CBGController extends Controller
{
    /**
     * @Route("/viewImportFileCBG", name="viewImportFileCBG")
     * @Template()
     */
    public function viewImportFileAction(Request $request)
    {
        #Criando o formulário
        $form = $this->createForm(new ArquivoCBGType());

        #Recuperando os serviços do container
        $arquivoCBGRN           = $this->get('rn_arquivoCBG');
        $arquivoCabecalhoCBGDAO = $this->get('dao_arquivoCabecalhoCBG');

        #Recupera os ultimos 15 arquivos
        $arquivosCabecalhosCBG  = $arquivoCabecalhoCBGDAO->findLastsDesc();

        #Verficando se é uma submissão
        if ($request->getMethod() === "POST") {
            #Repasando a requisição
            $form->handleRequest($request);

            #Verifica se os dados são válidos
            if ($form->isValid()) {
                #Recuperando os dados
                $arquivoCBG = $form->getData();

                #Recuperando o arquivo
                $path = __DIR__.'/../../../../../web/upload/files/'. $arquivoCBG->getImageName();

                #Verificando se o arquivo já existe
                if($arquivoCBGRN->findByName($arquivoCBG->getImageFile()->getClientOriginalName())) {
                    $this->get('session')->getFlashBag()->add('danger', "Arquivo já foi importado!");

                    #Retorno
                    return array("form" => $form->createView(), "arquivos" => $arquivosCabecalhosCBG);
                }

                #Executando e recuperando o resultado
                $resultUpload = $arquivoCBGRN->save($arquivoCBG);

                #Verifica se a o upload foi realizado com sucesso
                if(!$resultUpload) {
                    $this->get('session')->getFlashBag()->add('danger', "Erro ao importar o arquivo!");

                    #Retorno
                    return array("form" => $form->createView(), "arquivos" => $arquivosCabecalhosCBG);
                }

                #Processamento do arquivo, montando à arvore de objetos.
                $arquivoCabecalhoCBG = ProcessamentoCBGUtil::processar($resultUpload->getImageName());
                $arquivoCabecalhoCBG->setArquivoCBG($resultUpload);

                #Recuperando os serviços do container
                $CBGRN  = $this->get('rn_CBG');
                $result = $CBGRN->salvar($arquivoCabecalhoCBG);

                #Recupera os ultimos 15 arquivos
                $arquivosCabecalhosCBG  = $arquivoCabecalhoCBGDAO->findLastsDesc();

                #Verificando a resposta
                if(!$result) {
                    #Mensagem de erro
                    $this->get('session')->getFlashBag()->add('danger', "Erro ao importar o arquivo!");
                } else {
                    #Mensagem de sucesso
                    $this->get('session')->getFlashBag()->add('success', "Arquivo importado com sucesso!");
                }

                #Criando o formulário
                $form = $this->createForm(new ArquivoCBGType());

                #Retorno
                return array("form" => $form->createView(), "arquivos" => $arquivosCabecalhosCBG);
            } else {
                #Messagem de retorno
                $this->get('session')->getFlashBag()->add('danger', (string) $form->getErrors());
            }
        }

        #Retorno
        return array("form" => $form->createView(), "arquivos" => $arquivosCabecalhosCBG);
    }


    /**
     * @Route("delete/{id}", name="delete")
     */
    public function delete($id)
    {
        $manager = $this->getDoctrine()->getManager();
        $entity  = $manager->find("NewCBOBundle:ArquivoCabecalhoCBG", $id);

        $manager->remove($entity);
        $manager->flush();

        #Mensagem de sucesso
        $this->get('session')->getFlashBag()->add('success', "Arquivo deletado com sucesso!");

        #Retorno
        return $this->redirectToRoute("viewImportFileCBG");
    }

    /**
     *
     * @Route("/gridTransacoesCBG", name="gridTransacoesCBG")
     * @Template()
     *
     * @param Request $request
     * @return \SerBinario\MBCredito\CBOBundle\Controller\JsonResponse
     */
    public function gridTransacoesCBGAction(Request $request)
    {
        if(GridClass::isAjax()) {

            $columns = array(
                "a.chaveOperador",
                "a.valorParcela"
            );

            $entityJOIN = array();

            $detalheArray     = array();
            $parametros       = $request->request->all();
            $entity           = "SerBinario\MBCredito\NewCBOBundle\Entity\TransacoesCBG";
            $columnWhereMain  = "";
            $whereValueMain   = "";
            $whereFull        = "" ;

            $gridClass = new GridClass($this->getDoctrine()->getManager(),
                $parametros,
                $columns,
                $entity,
                $entityJOIN,
                $columnWhereMain,
                $whereValueMain,
                $whereFull);


            $resultDetalhe   = $gridClass->builderQuery();
            $countTotal      = $gridClass->getCount();
            $countDetalhe    = count($resultDetalhe);
            var_dump($countDetalhe);exit;
            for($i=0;$i < $countDetalhe; $i++)
            {
                $detalheArray[$i]['DT_RowId']  = "row_". $i;
                $detalheArray[$i]['chave']     =  $resultDetalhe[$i]->getChaveOperador();
                $detalheArray[$i]['valor']     =  number_format($resultDetalhe[$i]->getValorParcela(), 2, ',', '.');
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
}
