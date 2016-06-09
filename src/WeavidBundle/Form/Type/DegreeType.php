<?php
namespace WeavidBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DegreeType extends AbstractType{

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
				'Keiner' => 'NONE',
				'Abitur' => 'ALEVEL',
				'Bachelor' => 'BACHELOR',
				'Master' => 'MASTER',
				'Diplom' => 'DIPLOM',
				'Magister' => 'MAGISTER',
				'Doktor' => 'PHD',
				'Andere' => 'OTHER'
			],
			'label' => 'Abschluss'
		));
	}


}