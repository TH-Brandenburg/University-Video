<?php
namespace WeavidBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
        $builder->add('languageTag', LanguageType::class, [
            'label' => 'Sprache',
            'preferred_choices' => [
                'de', 'en'
            ]
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
        $builder->add('category', EntityType::class, [
            'class' => 'WeavidBundle\Entity\Category',
            'choice_label' => 'label',
            'multiple' => true,
            'expanded' => true,
            'label' => 'Kategorien'
        ]);
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $video = $event->getData();
            $form = $event->getForm();

            // Check if video is new and add label depending on it
            if (!$video || null === $video->getId()) {
                $form->add('save', SubmitType::class, ['label' => 'Video hinzufügen']);
            } else {
                $form->add('save', SubmitType::class, ['label' => 'Änderungen speichern']);
            }
        });
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