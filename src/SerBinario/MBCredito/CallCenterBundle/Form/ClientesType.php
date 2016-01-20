<?php

namespace SerBinario\MBCredito\CallCenterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SerBinario\MBCredito\CallCenterBundle\Form\ChamadasType;
use SerBinario\MBCredito\CallCenterBundle\Form\TelefonesType;

class ClientesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', 'text', array(
                'label' => 'Nome: ',               
                'attr'  => array(
                    'placeholder' => 'Nome do cliente',
                    'widget_col'=> '4',
                )))
            ->add('cpf', 'text', array(
                'label' => 'CPF: ',                 
                'attr'  => array(
                    'placeholder' => 'CPF do cliente',
                    'widget_col'=> '4',
                    "class"    => "mask_cpf"
                )))
            ->add('agencia', 'entity', array(
                'label'        => 'Agencia: ',
                'required'     => true,
                'empty_value' => false,
                'class' => 'SerBinario\MBCredito\CallCenterBundle\Entity\Agencias',
                'attr' => array(
                     'widget_col'=> '4',
                    )
                ))
            ->add('conta', 'text', array(
                'label' => 'Conta: ',                
                'attr'  => array(
                    'placeholder' => 'Conta do cliente',
                    'widget_col'=> '4',
                )))
            ->add('telefones', 'bootstrap_collection', array(
                'label'    => "Telefones: ",
                'type'     => new TelefonesType(), 
                'allow_add'          => true,
                'allow_delete'       => true,
                'add_button_text'    => 'Adicionar',
                'delete_button_text' => 'Remover',
                'sub_widget_col'     => 3,
                'button_col'         => 6            
                ))
            ->add('chamadas', new ChamadasType())
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
            'data_class' => 'SerBinario\MBCredito\CallCenterBundle\Entity\Clientes',
            'csrf_protection'  =>  true ,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'task_item',
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'serbinario_mbcredito_callcenterbundle_clientes';
    }
}
