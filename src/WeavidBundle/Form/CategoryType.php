<?php
namespace WeavidBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array       $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder->add('label', TextType::class, [
			'label' => 'Bezeichnung',
			'required' => true
		]);
		$builder->add('parent', EntityType::class, [
			'class' => 'WeavidBundle\Entity\Category',
			'choice_label' => 'label',
			'placeholder' => 'Keine',
			'label' => 'In Kategorie',
			'required' => false
		]);
		$builder->add('save', SubmitType::class, ['label' => 'Kategorie hinzufügen']);
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'WeavidBundle\Entity\Category',
			'constraints' => [
			]
		));
	}


}