<?php

namespace BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class CategoryType extends AbstractType
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pid', ChoiceType::class, array(
            'required' => false,
            'placeholder' => 'Основний',
            'choices' => $this->par(),
        ));
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
                'slug' => array(
                    'label' => 'Alias',
                    'field_type' => TextType::class,
                    'required' => false
                ),
            ),
            'label' => false
        ));
        $builder->add('levels', Select2EntityType::class, [
            'remote_route' => 'admin_search_levels',
            'class' => 'BlogBundle:Levels',
            'placeholder' => 'Add levels',
            'minimum_input_length' => 0,
            'required'=> true,
            'multiple'=> true,
            'allow_clear'=> true,
            'delay'=> 500,
            'cache'=> true,
            'cache_timeout'=> 60000,
            'page_limit'=> 50,
            'scroll'=> true,
            'width'=> '100%'
        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Categories'
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