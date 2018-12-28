<?php

namespace MenuBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityManager;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RouteType extends AbstractType
{

    protected $em;
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('module', ChoiceType::class, array(
            'mapped' => false,
            'required' => false,
            'placeholder' => 'Всі модулі',
            'choices' => $this->getRoute(),
        ));
    }

    public function getRoute()
    {
        $result = $this->em->getRepository("MenuBundle:Routes")->findBy(['param_id' => NULL, 'param_slug' => NULL]);
        $return = array();
        foreach ($result as $value) {
            $return[$value->getModule()] = $value->getModule();
        }
        return $return;
    }

}