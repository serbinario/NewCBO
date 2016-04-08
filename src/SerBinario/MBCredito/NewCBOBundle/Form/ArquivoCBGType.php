<?php

namespace SerBinario\MBCredito\NewCBOBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArquivoCBGType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', 'vich_file', array(
                'required'      => true,
                'label'         => 'Arquivo CBG *'
                //'allow_delete'  => true, // not mandatory, default is true
                //'download_link' => true, // not mandatory, default is true
            ))
            ->add('actions', 'form_actions', [
                'buttons' => [
                    'save' => ['type' => 'submit', 'options' => ['label' => 'Salvar']]                    
                ]
            ]);         
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SerBinario\MBCredito\NewCBOBundle\Entity\ArquivoCBG'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'serbinario_mbcredito_newcbobundle_arquivocbg';
    }
}
