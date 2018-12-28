<?php

namespace UsersBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ProfileFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class);
        $builder->add('phone', TelType::class, ['required' => true]);
        $builder->add('email', TextType::class);
        $builder->add('new_password', RepeatedType::class, array('required' => false, 'mapped' => false, 'data' => NUll, 'type' => PasswordType::class, 'invalid_message' => 'Passwords do not match'));
        $builder->add('lastname', TextType::class);
        $builder->add('firstname', TextType::class);
        $builder->add('patronymic', TextType::class, array('required' => false));
        $builder->add('birthday', DateType::class, array('widget' => 'single_text', 'html5' => false, 'attr' => ['class' => 'js-datepicker']));
        $builder->add('file', FileType::class, array('required' => true));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }

}
