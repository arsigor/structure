<?php
namespace GalleryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class GalleryImagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('files', FileType::class, array(
                'error_bubbling' => true,
                'required'=>false,
                'multiple'   => true,
                'data_class' => null,
                'constraints' => array(
                    new All(array(
                        'constraints' => array(
                            new File(array(
                                'maxSize'   => '20M',
                                'mimeTypes' => ["image/png","image/jpeg", "image/gif"],
                                ))
                            )
                    )))
                ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GalleryBundle\Entity\GalleryImages',
        ));
    }
}
