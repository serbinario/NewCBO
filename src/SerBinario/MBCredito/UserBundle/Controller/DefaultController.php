<?php

namespace SerBinario\MBCredito\UserBundle\Controller;

use SerBinario\MBCredito\UserBundle\Entity\Role;
use SerBinario\MBCredito\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

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

//    /**
//     * @Route("/teste", name="teste")
//     */
//    public function testeAction()
//    {
//        $manager    = $this->getDoctrine()->getManager();
//
//
//        $role       = $manager->getRepository("UserBundle:Role")->find(2);
//
//        //for ($i = 52; $i <= 68; $i++) {
//           // $operador = $manager->getRepository("NewCBOBundle:Operadores")->find($i);
//            $user = new User();
//            $user->addRole($role);
//            $user->setUsername("mbcredito");
//            $encoder = $this->container->get('security.password_encoder');
//            $encoded = $encoder->encodePassword($user, "mbcredito");
//            $user->setPassword($encoded);
//            //$user->setOperador($operador);
//            $user->setIsActive(true);
//
//            $manager->persist($user);
//            $manager->flush();
//        //}
//
//
//    }
}
