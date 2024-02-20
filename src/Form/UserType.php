<?php

namespace App\Form;

use App\Entity\User;
use PhpParser\Parser\Multiple;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo',TextType::class, [
                'label_attr'=> ['class'=>'block text-gray-700 text-sm font-bold mb-2'],
                'attr'=>['class'=>'registration_form_input w-full rounded-md']
            ])
            ->add('email',EmailType::class, [
                'label_attr'=> ['class'=>'block text-gray-700 text-sm font-bold mb-2'],
                'attr'=>['class'=>'registration_form_input w-full rounded-md']
            ])
            ->add('roles',ChoiceType::class,[
            'label_attr'=>['class'=>'font-bold mb-2'],
            'attr'=>['class'=>'mb-4'],
               'multiple'=>true,
               'expanded'=>true,
               'choices' => [
                'ROLE_ADMIN'=>'ROLE_ADMIN',
                
               ] 
            ]);
            if($options['is_edit']){
               $builder ->add('plainPassword',RepeatedType::class,[
                    'invalid_message'=>'The password fields must match.',
                    'options' => ['attr'=>['class'=>'registration_form_input w-full rounded-md','password-field' ],
                        'label_attr'=> ['class'=>'block text-gray-700 text-sm font-bold mb-2']
            
                        ],
                    'required' => true,
                    'mapped'=>false,
                    'first_options'  => ['label' => 'Password'],
                    'second_options' => ['label' => 'Repeat Password']
                    ]);
            }
           
           $builder ->add('isVerified');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_edit'=>false
        ]);
    }
}
