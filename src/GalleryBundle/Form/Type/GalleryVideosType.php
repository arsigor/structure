<?php

namespace GalleryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class GalleryVideosType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('translations', TranslationsType::class, array(
                        'fields' => array(
                            'title' => array(
                                'label' => 'Title',
                                'field_type' => TextType::class,
                                'required' => true
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
        $builder->add('uri', UrlType::class, array(
            'required' => true
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GalleryBundle\Entity\GalleryVideos',
        ));
    }
}