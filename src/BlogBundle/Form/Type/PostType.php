<?php

namespace BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityManager;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class PostType extends AbstractType
{
    protected $em;
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('translations', TranslationsType::class, array(
            'fields' => array(
                'title' => array(
                    'label' => 'Title',
                    'field_type' => TextType::class,
                    'required' => true
                ),
                'brief' => array(
                    'label' => 'Brief',
                    'field_type' => TextareaType::class,
                    'required' => false,
                ),
                'description' => array(
                    'label' => 'Post',
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
                    'field_type' => TextareaType::class,
                    'required' => false
                ),
            ),
            'label' => false
        ));
        $builder->add('begin_date', DatetimeType::class, array('widget' => 'single_text', 'html5' => false));
        $builder->add('file1', FileType::class, array('required' => false));
        $builder->add('category_id', ChoiceType::class, array(
            'placeholder' => '- необхідно обрати -',
            'choices' => $this->par(),
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Posts'
        ));
    }

    public function par()
    {
        $result = $this->em->getRepository("BlogBundle:Categories")->findBy(['pid' => NULL]);
        $return = array();
        foreach ($result as $value) {
            $return[$value->getTitle()] = $value->getId();
            if(count($value->getChildrens())>0){
                $separator = '-';
                $return = $this->chi($value->getId(), $return, $separator);
            }
        }
        return $return;
    }

    public function chi($id, $return, $separator)
    {
        $result = $this->em->getRepository("BlogBundle:Categories")->findBy(['pid' => $id]);
        foreach ($result as $value) {
            $return[$separator.$value->getTitle()] = $value->getId();
            if(count($value->getChildrens())>0){
                $separator .= '-';
                $return = $this->chi($value->getId(), $return, $separator);
            }
        }
        return $return;
    }
}