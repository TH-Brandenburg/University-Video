<?php
namespace WeavidBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobStatusType extends AbstractType{

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
				'Student' => 'STUDENT',
				'Angestellt' => 'EMPLOYED',
				'Wissenschaftler' => 'SCIENTIST',
				'Lehrender' => 'TEACHER',
				'Andere' => 'OTHER',
			],
			'label' => 'Berufsstatus'
		));
	}


}