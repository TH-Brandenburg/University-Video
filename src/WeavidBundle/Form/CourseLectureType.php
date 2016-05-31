<?php
namespace WeavidBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WeavidBundle\Entity\Video;

class CourseLectureType extends AbstractType{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array       $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder->add('lectures', EntityType::class, [
			'class' => 'WeavidBundle\Entity\Lecture',
			'choice_label' => 'label',
			'mapped' => false
		]);
		$builder->add('save', SubmitType::class, ['label' => 'Vorlesung hinzufügen']);
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