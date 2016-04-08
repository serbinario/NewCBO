<?php

namespace SerBinario\MBCredito\CallCenterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConveniosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('convenio', 'text', array(
                'label' => 'Nome: ',               
                'attr'  => array(
                    'placeholder' => 'Nome do Convênio',
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
            'data_class' => 'SerBinario\MBCredito\CallCenterBundle\Entity\Convenios'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'serbinario_mbcredito_callcenterbundle_convenios';
    }
}
