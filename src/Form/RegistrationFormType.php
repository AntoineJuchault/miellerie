<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Courriel:',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom:',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom:',
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse:',
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Code postal:',
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville:',
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Accepter les termes',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
            ])
            ->add('plainPassword',RepeatedType::class,   [
                'type' => PasswordType::class,
                'label' => 'Mot de passe',
                'first_options'  => ['label' => 'Renseignez un Mot de Passe:'],
                'second_options' => ['label' => 'Confirmez votre mot de passe:'],
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un mot de passe \n',
                    ]), 
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
