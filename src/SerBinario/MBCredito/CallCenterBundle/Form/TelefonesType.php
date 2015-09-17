<?php

namespace SerBinario\MBCredito\CallCenterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TelefonesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder     
            ->add('telefone', 'text', array(
                'label' => false,               
                'attr'  => array(
                    'placeholder' => 'Telefone do cliente',
                    'widget_col'=> '10',
                    "class"    => "telefoneCollection"
                )))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SerBinario\MBCredito\CallCenterBundle\Entity\Telefones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'serbinario_mbcredito_callcenterbundle_telefones';
    }
}
