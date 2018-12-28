<?php

namespace MenuBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class ItemGroupType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('number', IntegerType::class);
        $builder->add('translations', TranslationsType::class, array(
            'fields' => array(
                'title' => array(
                    'label' => 'Title',
                    'field_type' => TextType::class,
                    'required' => false
                ),
            ),
            'label' => false
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MenuBundle\Entity\Items'
        ));
    }

}