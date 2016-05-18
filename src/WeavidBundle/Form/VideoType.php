<?php
namespace WeavidBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoType extends AbstractType{
    /**
     * @param FormBuilderInterface $builder
     * @param array       $options
     */
    public function buildForm( FormBuilderInterface $builder, array $options ) {
        $builder->add('title', TextType::class, [
            'label' => 'Videotitel'
        ]);
        $builder->add('description', TextareaType::class, [
            'label' => 'Videobeschreibung'
        ]);
        $builder->add('released', CheckboxType::class, [
            'label' => 'Freigegeben',
            'required' => false
        ]);
        $builder->add('public', CheckboxType::class, [
            'label' => 'Öffentlich',
            'required' => false
        ]);
        $builder->add('primaryVideoUrl', UrlType::class, [
            'label' => 'Video #1'
        ]);
        $builder->add('secondaryVideoUrl', UrlType::class, [
            'label' => 'Video #2'
        ]);
        $builder->add('save', SubmitType::class, ['label' => 'Video hinzufügen']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WeavidBundle\Entity\Video',
            'constraints' => [
            ]
        ));
    }


}