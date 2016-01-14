<?php

namespace SerBinario\MBCredito\CallCenterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

class ChamadasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $arrayPrazo = array();
        
        for ($i = 1; $i <= 96; $i++) {
            $arrayPrazo[] = $i;
        }
        
        $builder            
            ->add('prazo', 'choice', array(
                    'choice_list' => new ChoiceList($arrayPrazo, $arrayPrazo),
                    'required'     => true,
                    'label' => 'Quantidade de parcelas: ',
                    'attr'  => array(                        
                        'widget_col'=> '4',                        
                    )                    
                ))     
            ->add('codigoTransacao', 'integer', array(
                    'required'     => true,
                    'label' => 'N° do contrato: ',
                    'attr'  => array(                        
                        'widget_col'=> '4', 
                        'placeholder' => 'N° do contrato',
                        'max_length'=>11
                       # "class"    => "mask_numero"
                    )                    
                ))
            ->add('valorContratado', 'text', array(
                'label' => 'Valor do contrato: ',
                'required'     => true,
                'attr'  => array(
                    'placeholder' => 'valor do contrato',
                    'widget_col'=> '4',
                    "class"    => "money"
                )))
            ->add('dataContratado', 'date', array(
                'widget' => 'single_text',
                'required'     => true,
                'format' => 'dd/MM/yyyy',
                'label' => 'Data da contratação',                
                'attr' => array(
                    'placeholder' => 'Data da contratação',
                    'widget_col'=> '2',
                    "class"    => " datenottime"
                )
            ))           
            ->add('tipoContrato', 'entity', array(
                'label'        => 'Tipos de créditos',
                'required'     => true,
                'empty_value' => false,
                'class' => 'SerBinario\MBCredito\CallCenterBundle\Entity\TipoContrato',
                'attr' => array(
                     'widget_col'=> '4',
                    )
                ))
            ->add('convenio', 'entity', array(
                'label'        => 'Convenio: ',
                'required'     => true,
                'empty_value' => false,
                'class' => 'SerBinario\MBCredito\CallCenterBundle\Entity\Convenios',
                'attr' => array(
                     'widget_col'=> '4',
                    )
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SerBinario\MBCredito\CallCenterBundle\Entity\Chamadas'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'serbinario_mbcredito_callcenterbundle_chamadas';
    }
}
