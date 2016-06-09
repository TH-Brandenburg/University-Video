<?php
namespace WeavidBundle\Form;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use WeavidBundle\Form\Type\DegreeType;
use WeavidBundle\Form\Type\GenderType;
use WeavidBundle\Form\Type\JobExperienceType;
use WeavidBundle\Form\Type\JobPositionType;
use WeavidBundle\Form\Type\JobStatusType;

class RegistrationType extends AbstractType{
    /**
     * @param FormBuilderInterface $builder
     * @param array       $options
     */
    public function buildForm( FormBuilderInterface $builder, array $options ) {
        $builder->add('email', EmailType::class, [
            'label' => 'E-Mail',
            'attr' => [
                'placeholder' => 'mail@example.com',
                'title' => 'Bitte verwenden Sie für die Registrierung keine E-Mailadresse der Hochschule.'
            ],
            'constraints' => [
                new Regex([
                    'pattern' => '/[a-zA-Z0-9\.]+@fh-brandenburg\.de$|[a-zA-Z0-9\.]+@th-brandenburg\.de$/',
                    'match' => false,
                    'message' => 'Für die Registrierung bitte keine Hochschuladresse verwenden.'
                ])
            ]
        ]);
        $builder->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Die Passwörter müssen übereinstimmen.',
            'required' => true,
            'first_options' => [
                'label' => 'Passwort',
                'constraints' => [
                    new Length(['min' => 8])
                ],
            ],
            'second_options' => [
                'label' => 'Passwort wiederholen'
            ]
        ]);
        $builder->add('firstName', TextType::class, [
            'label' => 'Vorname'
        ]);
        $builder->add('lastName', TextType::class, [
            'label' => 'Nachname'
        ]);
        $builder->add('gender', GenderType::class);
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
        $builder->add('save', SubmitType::class, ['label' => 'Registrieren']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WeavidBundle\Entity\User',
            'constraints' => [
                new UniqueEntity([
                    'fields' => ['email'],
                    'message' => 'Diese E-Mail Adresse ist bereits vergeben.'
                ])
            ]
        ));
    }


}