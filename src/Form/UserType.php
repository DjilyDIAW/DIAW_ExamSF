<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'attr' => [
                'placeholder' => "Veuillez saisir un email",
                ],
            ])

            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['placeholder' => "Veuillez saisir un mot de passe avec 8 caractères, 1 chiffre et 1 lettre",
                     'autocomplete' => 'new-password'],
                     'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                   new Length([
                       'min' => 8,
                       'minMessage' => 'Your password should be at least {{ limit }} characters with 1 number and 1 letter',
                       'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => '/(?=\S*[a-z])(?=\S*\d)/',
                        'message' => 'Your password should contain at least 1 number and 1 letter',
                    ]),
                ],
            ])
            ->add('nom', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])

            ->add('prenom', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])

            ->add('photo', FileType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un format valide (png, jpg)',
                    ])
                ],
            ])
            ->add('secteur', ChoiceType::class,[
                'choices' => [
                    'RH' => 'rh',
                    'Informatique' => 'Informatique',
                    'Comptabilité' => 'Comptabilité',
                    'Direction' => 'Direction',
                ]
            ])
            ->add('type_contrat', ChoiceType::class,[
                'choices' => [
                    'CDI' => 'cdi',
                    'CDD' => 'cdd',
                    'Interim' => 'interim',
                ]
            ])
            ->add('date_sortie', DateType::class,[
                "attr" => [
                    "class" => "form-control"
                ]
            ])

        ;


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection'=> true

        ]);
    }
}
