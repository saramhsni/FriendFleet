<?php

namespace App\Form;

use App\Entity\User;
use PhpParser\Parser\Multiple;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class, [
                'label_attr'=> ['class'=>'block text-gray-700 text-sm font-bold mb-2'],
                'attr'=>['class'=>'shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']
            ])
            ->add('roles',ChoiceType::class,[
               'multiple'=>true,
               'expanded'=>true,
               'choices' => [
                'ROLE_ADMIN'=>'ROLE_ADMIN',
                'ROLE_MEMBER'=>'ROLE_MEMBER',
               ] 
            ])
            ->add('plainPassword',RepeatedType::class,[
                'invalid_message'=>'The password fields must match.',
                'options' => ['attr'=>['class'=>'shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline','password-field' ],
                    'label_attr'=> ['class'=>'block text-gray-700 text-sm font-bold mb-2']
        
                    ],
                'required' => true,
                'mapped'=>false,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password']
            ])
            ->add('isVerified')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
