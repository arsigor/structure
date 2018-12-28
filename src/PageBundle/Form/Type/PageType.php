<?php

namespace PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class PageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('translations', TranslationsType::class, array(
                        'fields' => array(
                            'title' => array(
                                'label' => 'Title',
                                'field_type' => TextType::class,
                                'required' => false
                            ),
                            'description' => array(
                                'label' => 'Description',
                                'field_type' => TextareaType::class,
                                'required' => false
                            ),
                            'slug' => array(
                                'label' => 'Alias',
                                'field_type' => TextType::class,
                                'required' => false
                            ),
                            'seo_title' => array(
                                'label' => 'Title',
                                'field_type' => TextType::class,
                                'required' => false
                            ),
                            'seo_keyword' => array(
                                'label' => 'Keyword',
                                'field_type' => TextType::class,
                                'required' => false
                            ),
                            'seo_description' => array(
                                'label' => 'Description',
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
            'data_class' => 'PageBundle\Entity\Pages'
        ));
    }

}