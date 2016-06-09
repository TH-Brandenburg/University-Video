<?php
namespace WeavidBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobPositionType extends AbstractType{

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
				'Praktikant' => 'INTERN',
				'Fachexperte' => 'TECHNICIAN',
				'Projektleitung' => 'PROJECTMAN',
				'Teamleiter' => 'TEAMLEAD',
				'Abteilungsleiter' => 'DEPHEAD',
			],
			'label' => 'Berufl. Position'
		));
	}


}