<?php

namespace SerBinario\MBCredito\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'label' => 'Login: ',
                'attr'  => array(
                    'placeholder' => 'Digite o login',
                    'widget_col'=> '4',
                )))
            ->add('password', 'password', array(
                'label' => 'Senha: ',
                'attr'  => array(
                    'placeholder' => 'Digite a senha',
                    'widget_col'=> '4',
                )))
            ->add('email', 'text', array(
                'label' => 'Email: ',
                'required'     => false,
                'attr'  => array(
                    'placeholder' => 'Digite o email',
                    'widget_col'=> '4',
                )))
            ->add('roles', 'entity', array(
                'label'        => 'Permissões: ',
                'required'     => true,
                'empty_value' => false,
                'multiple' => true,
                'expanded' => true,
                'class' => 'SerBinario\MBCredito\UserBundle\Entity\Role',
                'attr' => array(
                    'widget_col'=> '4',
                    'inline' => "true",
                )
            ))
            ->add('operador','entity', array(
                'label'        => 'Operador: ',
                'class' => 'SerBinario\MBCredito\NewCBOBundle\Entity\Operadores',
                'empty_value' => "Escolha um operador",
                'required'     => false,
                'attr' => array(
                    'widget_col'=> '4',
                )
            ))
            ->add('actions', 'form_actions', [
                'buttons' => [
                    'save' => ['type' => 'submit', 'options' => ['label' => 'Salvar']],
                    'voltar' => ['type' => 'button', 'options' => ['label' => 'Voltar']],
                ]
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SerBinario\MBCredito\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'serbinario_mbcredito_userbundle_user';
    }
}
