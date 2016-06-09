<?php
namespace WeavidBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobExperienceType extends AbstractType{

	public function getParent() {
		return ChoiceType::class;
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'choices' => [
				'Keine' => 'NONE',
				'< 5 Jahre' => 'UPTO5',
				'5 - 10 Jahre' => 'UPTO10',
				'> 10 Jahre' => 'MORETHAN10',
			],
			'label' => 'Berufserfahrung'
		));
	}


}