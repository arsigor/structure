<?php
namespace GalleryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('path', HiddenType::class, array('required' => true));
        $builder->add('title', TextType::class, array('required' => true));
        $builder->add('file', FileType::class, array(
                'error_bubbling' => true,
                'required'=>true,
                'constraints' => array(
                        new File(array(
                            'maxSize'   => '20M',
                            'mimeTypes' => ["image/png","image/jpeg", "image/gif"],
                            ))
                        )
                ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GalleryBundle\Entity\GalleryImages',
        ));
    }
}
