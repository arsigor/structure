<?php
namespace UsersBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class UserType extends AbstractType
{
    protected $em;
    protected $container;

    public function __construct($container, $entityManager)
    {
        $this->em = $entityManager;
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $security_roles = $this->container->getParameter('security.role_hierarchy.roles');

        $rolesArray = array();
        foreach($security_roles as $r){
            $rolesArray[substr($r[0],5)] = $r[0];
        }

        $builder->add('username', TextType::class);
        $builder->add('email', TextType::class);
        $builder->add('new_password', RepeatedType::class, array('required' => false, 'mapped' => false, 'data' => NUll, 'type' => PasswordType::class, 'invalid_message' => 'Passwords do not match'));
        $builder->add('enabled', ChoiceType::class, array('choices' => array('Да'=>true,'Нет'=>false)));
        $builder->add('role', ChoiceType::class, array('choices' => $rolesArray, 'data' => $builder->getData()->getRoles()[0]));
        $builder->add('lastname', TextType::class);
        $builder->add('firstname', TextType::class);
        $builder->add('patronymic', TextType::class, array('required' => false));
        $builder->add('birthday', DateType::class, array('widget' => 'single_text', 'html5' => false, 'attr' => ['class' => 'js-datepicker']));
        $builder->add('file', FileType::class, array('required' => false,));
//        $builder->add('levels', EntityType::class,
//            ['class' => 'BlogBundle:Levels', 'choice_label' => 'title']
//        );
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

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UsersBundle\Entity\Users',
        ));
    }

    function getName()
    {
        return 'user';
    }

}