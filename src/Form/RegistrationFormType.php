<?php

namespace App\Form;

use App\Entity\User;
use App\Form\UserProfileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('pseudo')
            ->add('email', EmailType::class, [
                'invalid_message'=>'Enter a valid email.',
            ])
            
            ->add('plainPassword', RepeatedType::class, [
                'type'=>PasswordType::class,
                'mapped' => false,
                'invalid_message'=>'The password fiels must match.',
                'attr' => ['autocomplete' => 'new-password'],
                'first_options'=>[
                    'label'=>'password',
                    'mapped'=>false
                ],
                'second_options'=>[
                    'label'=>'Repeated password',
                    'mapped'=>false
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/',
                        'message' => 'The password must contain at least 8 characters with 
                        at least one lowercase letter, one uppercase letter, one digit, and one special character.',
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label'=>'accept bacheee',
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('userProfile',UserProfileType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
