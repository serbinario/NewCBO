<?php

namespace SerBinario\MBCredito\CallCenterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AgenciasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroAgencia', 'integer', array(
                'label' => 'Número: ',               
                'attr'  => array(
                    'placeholder' => 'Número da Agencia',
                    'widget_col'=> '4',
                )))
            ->add('nomeAgencia', 'text', array(
                'label' => 'Nome: ',               
                'attr'  => array(
                    'placeholder' => 'Nome da Agencia',
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
            'data_class' => 'SerBinario\MBCredito\CallCenterBundle\Entity\Agencias'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'serbinario_mbcredito_callcenterbundle_agencias';
    }
}
