<?php
namespace WeavidBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array       $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder->add('label', TextType::class, [
			'label' => 'Name',
			'required' => true
		]);
		$builder->add( 'description', TextareaType::class, [
			'label' => 'Beschreibung',
			'required' => true
		]);
		$builder->add('published', CheckboxType::class, [
			'label' => 'Veröffentlicht',
			'required' => false
		]);
		$builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
			$course = $event->getData();
			$form = $event->getForm();

			// Check if course is new and add label depending on it
			if (!$course || null === $course->getId()) {
				$form->add('save', SubmitType::class, ['label' => 'Kurs anlegen']);
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
			'data_class' => 'WeavidBundle\Entity\Course',
			'constraints' => [
			]
		));
	}


}