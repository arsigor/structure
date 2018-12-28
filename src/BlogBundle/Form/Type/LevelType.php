<?php

namespace BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class LevelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('translations', TranslationsType::class, array(
            'fields' => array(
                'translatable_id' => array(
                    'field_type' => HiddenType::class,
                ),
                'title' => array(
                    'label' => 'Title',
                    'field_type' => TextType::class,
                    'required' => true
                ),
            ),
            'label' => false
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Levels'
        ));
    }
}