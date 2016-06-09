<?php
namespace WeavidBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WeavidBundle\Form\Type\DegreeType;
use WeavidBundle\Form\Type\GenderType;
use WeavidBundle\Form\Type\JobExperienceType;
use WeavidBundle\Form\Type\JobPositionType;
use WeavidBundle\Form\Type\JobStatusType;

class UserType extends AbstractType{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array       $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder->add('firstName', TextType::class, [
			'label' => 'Vorname'
		]);
		$builder->add('lastName', TextType::class, [
			'label' => 'Nachname'
		]);
		$builder->add('gender', GenderType::class, [
			'label' => 'Geschlecht'
		]);
		$builder->add('country', CountryType::class, [
			'label' => 'Land',
			'placeholder' => 'Bitte auswählen...'
		]);
		$builder->add('city', TextType::class, [
			'label' => 'Stadt'
		]);
		$builder->add('organization', TextType::class, [
			'label' => 'Organisation'
		]);
		$builder->add('degree', DegreeType::class);
		$builder->add('jobStatus', JobStatusType::class);
		$builder->add('jobPosition', JobPositionType::class);
		$builder->add('jobExperience', JobExperienceType::class);
		$builder->add('save', SubmitType::class, ['label' => 'Änderungen speichern']);
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'WeavidBundle\Entity\User',
			'constraints' => [
			]
		));
	}


}