<?php

namespace SerBinario\MBCredito\NewCBOBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OperadoresType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codOperadores', 'text', array(
                'label' => 'Chave J: ', 
                'read_only' =>'true',
                'attr'  => array(
                    'placeholder' => 'Chave J',
                    'widget_col'=> '4',
            )))
            ->add('nomeOperadores', 'text', array(
                'label' => 'Nome: ',           
                'attr'  => array(
                    'placeholder' => 'Nome do Agente',
                    'widget_col'=> '4',
            )))
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
            'data_class' => 'SerBinario\MBCredito\NewCBOBundle\Entity\Operadores'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'serbinario_mbcredito_cbobundle_operadores';
    }
}
