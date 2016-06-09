<?php
namespace WeavidBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenderType extends AbstractType{

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
				'Keine Angabe' => 0,
				'Männlich' => 1,
				'Weiblich' => 2,
				'Sonstiges' => 9
			],
			'label' => 'Geschlecht'
		));
	}


}