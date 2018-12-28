<?php

namespace MenuBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityManager;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

class ItemType extends AbstractType
{

    protected $em;
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('menu', ChoiceType::class, array(
            'choices' => ['Ліве' => 1, 'Праве' => 2],
        ));
        $builder->add('pid', ChoiceType::class, array(
            'required' => false,
            'placeholder' => 'Основний',
            'choices' => $this->par(),
        ));
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

    public function par()
    {
        $result = $this->em->getRepository("MenuBundle:Items")->findBy(['pid' => NULL]);
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
        $result = $this->em->getRepository("MenuBundle:Items")->findBy(['pid' => $id]);
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