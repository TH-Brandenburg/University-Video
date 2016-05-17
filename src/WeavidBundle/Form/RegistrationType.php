<?php
namespace WeavidBundle\Form;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

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
        $builder->add('firstName', TextType::class);
        $builder->add('lastName', TextType::class);
        $builder->add('country', TextType::class);
        $builder->add('city', TextType::class);
        $builder->add('organization', TextType::class);
        $builder->add('degree', TextType::class);
        $builder->add('jobStatus', TextType::class);
        $builder->add('jobPosition', TextType::class);
        $builder->add('jobExperience', TextType::class);
        $builder->add('gender', TextType::class);
        $builder->add('save', SubmitType::class, ['label' => 'Registrieren']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WeavidBundle\Entity\Users',
            'constraints' => [
                new UniqueEntity([
                    'fields' => ['email'],
                    'message' => 'Diese E-Mail Adresse ist bereits vergeben.'
                ])
            ]
        ));
    }


}