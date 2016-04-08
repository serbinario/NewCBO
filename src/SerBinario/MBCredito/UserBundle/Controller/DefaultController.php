<?php

namespace SerBinario\MBCredito\UserBundle\Controller;

use SerBinario\MBCredito\UserBundle\Entity\Role;
use SerBinario\MBCredito\UserBundle\Entity\User;
use SerBinario\MBCredito\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use SerBinario\MBCredito\NewCBOBundle\Util\GridClass;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/index", name="index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // verificando se ocorreu um erro
        if ($error) {
            $this->addFlash("danger", "Usuário ou senha inválidos");
        }

        return array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error'         => $error,
        );

    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }

    /**
     * @Route("/gridUser", name="gridUser")
     * @Template()
     */
    public function gridUserAction(Request $request)
    {
        if(GridClass::isAjax()) {

            $columns = array(
                "a.username",
                "a.email"
            );

            $entityJOIN           = array();
            $agenciasArray        = array();
            $parametros           = $request->request->all();
            $entity               = "SerBinario\MBCredito\UserBundle\Entity\User";
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
                $agenciasArray[$i]['DT_RowId']  = "row_".$resultAgencias[$i]->getId();
                $agenciasArray[$i]['id']        = $resultAgencias[$i]->getId();
                $agenciasArray[$i]['username']  = $resultAgencias[$i]->getUsername();
                $agenciasArray[$i]['email']     = $resultAgencias[$i]->getEmail();
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
     * @Route("/saveUser", name="saveUser")
     * @Template()
     */
    public function saveUserAction(Request $request)
    {
        #Criando o formulário
        $form    = $this->createForm(new UserType());

        #Verficando se é uma submissão
        if($request->getMethod() === "POST") {
            #Repasando a requisição
            $form->handleRequest($request);

            #Verifica se os dados são válidos
            if($form->isValid()) {
                #Recuperando os dados
                $user        = $form->getData();

                #tratando a senha
                $encoder     = $this->container->get('security.password_encoder');
                $newPassword = $user->getPassword();
                $password    = $encoder->encodePassword($user, $newPassword);
                $user->setPassword($password);

                #Tratamento de exceções
                try {
                    $this->getDoctrine()->getRepository(User::class)->save($user);

                    $this->get('session')->getFlashBag()->add('success', 'Usuário cadastrado com sucesso');
                } catch (\Exception $ex) {
                    #Verificando a unicidade
                    if($ex->getPrevious()->getCode() == 23000) {
                        $this->get('session')->getFlashBag()->add('danger', 'Email o login já existentes');
                    } else {
                        $this->get('session')->getFlashBag()->add('danger', 'Erro ao cadastrar o usuário, tente novamente');
                    }
                }

                #Criando o formulário
                $form = $this->createForm(new UserType());

                #Retorno
                return array("form" => $form->createView());
                //return $this->redirectToRoute("gridAgencias");
            } else {
                #Messagem de retorno
                $this->get('session')->getFlashBag()->add('danger', (string) $form->getErrors());
            }

        }

        #Retorno
        return array("form" => $form->createView());
    }

    /**
     * @Route("/update/{id}", name="updateUser")
     * @Template()
     */
    public function updateUserAction(Request $request, $id)
    {
        #Recuperando o usuário
        $user        = $this->getDoctrine()->getRepository(User::class)->find($id);
        $oldPassword = $user->getPassword();
        $user->setPassword("");

        #Criando o formulário
        $form = $this->createForm(new UserType(), $user);

        #Verficando se é uma submissão
        if ($request->getMethod() === "POST") {
            #Repasando a requisição
            $form->handleRequest($request);

            #Verifica se os dados são válidos
            if ($form->isValid()) {
                #Recuperando os dados
                $user = $form->getData();

                #tratando a senha
                if(!empty($user->getPassword())) {
                    $encoder     = $this->container->get('security.password_encoder');
                    $newPassword = $user->getPassword();
                    $password    = $encoder->encodePassword($user, $newPassword);

                    $user->setPassword($password);
                } else {
                    $user->setPassword($oldPassword);
                }

                #Tratamento de exceções
                try {
                    $this->getDoctrine()->getRepository(User::class)->update($user);

                    $this->get('session')->getFlashBag()->add('success', 'Usuário cadastrado com sucesso');
                } catch (\Exception $ex) {
                    #Verificando a unicidade
                    if($ex->getPrevious() != null && $ex->getPrevious()->getCode() == 23000) {
                        $this->get('session')->getFlashBag()->add('danger', 'Email o login já existentes');
                    } else {
                        $this->get('session')->getFlashBag()->add('danger', 'Erro ao cadastrar o usuário, tente novamente');
                    }
                }

                #Recuperando o usuário
                $user = $this->getDoctrine()->getRepository(User::class)->find($id);

                #Criando o formulário
                $form = $this->createForm(new UserType(), $user);

                #Retorno
                return array("form" => $form->createView());
                //return $this->redirectToRoute("gridAgencias");
            } else {
                #Messagem de retorno
                $this->get('session')->getFlashBag()->add('danger', (string) $form->getErrors());
            }
        }

        #Retorno
        return array("form" => $form->createView());
    }

//    /**
//     * @Route("/teste", name="teste")
//     */
//    public function testeAction()
//    {
//        $manager    = $this->getDoctrine()->getManager();
//
//
//        $role       = $manager->getRepository("UserBundle:Role")->find(1);
//
//        for ($i = 52; $i <= 68; $i++) {
//            $operador = $manager->getRepository("NewCBOBundle:Operadores")->find($i);
//            $user = new User();
//            $user->addRole($role);
//            $user->setUsername($operador->getCodOperadores());
//            $encoder = $this->container->get('security.password_encoder');
//            $encoded = $encoder->encodePassword($user, $operador->getCodOperadores());
//            $user->setPassword($encoded);
//            $user->setOperador($operador);
//            $user->setIsActive(true);
//
//            $manager->persist($user);
//            $manager->flush();
//        }
//
//
//    }
}
