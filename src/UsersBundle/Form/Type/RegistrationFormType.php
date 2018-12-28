<?php

namespace UsersBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('phone', TelType::class, ['required' => true]);
        $builder->add('lastname', TextType::class, array('attr' => array('maxlength' => 255)));
        $builder->add('firstname', TextType::class, array('attr' => array('maxlength' => 255)));
        $builder->add('patronymic', TextType::class, array('required' => false, 'attr' => array('maxlength' => 255)));
        $builder->add('birthday', DateType::class, array('widget' => 'single_text', 'html5' => false, 'attr' => ['class' => 'js-datepicker']));
        $builder->add('file', FileType::class, array('required' => false));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

}