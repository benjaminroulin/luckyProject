<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class PhotoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('updatedAt', DateType::class , array(
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'label' => 'Date de la photo'
                ))
                ->add('alt')
                ->add('imageFile', VichImageType::class, [
                    'label' => 'Image plein écran',
                    'required' => false,
                    'allow_delete' => true,
                    'download_label' => true,
                    'download_uri' => true,
                    'image_uri' => true,
                ])
                ->add('Sauvegarder', SubmitType::class, array(
                        'attr' => array('class' => 'btn btn-primary savebutton'),
                    ))
                ->add('imageThumbFile', VichImageType::class, [
                    'label' => 'Image miniature',
                    'required' => false,
                    'allow_delete' => true,
                    'download_label' => true,
                    'download_uri' => true,
                    'image_uri' => true]);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Photo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_photo';
    }


}
