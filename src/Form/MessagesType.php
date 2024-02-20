<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Messages;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MessagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('title',TextType::class)
            ->add('message',TextareaType::class);
            if ($options['is_reply'] !== true){
                $builder->add('recipient', EntityType::class, [
                    'class' => User::class,
                    'choice_label' => 'email',
                    'label_attr' =>[
                        'class' => 'block text-sm text-gray-700 font-medium mx-8 mt-5'
                    ],
                    'attr' => [
                        'class' => 'block  shadow-sm border-gray-300 rounded-md border p-2 mt-1 mb-2 mx-8 registration_form_input',
                    ]
                ]);
            }
        $builder->add('submit', SubmitType::class, [
            'label' => 'Send message',
            'attr' => [
                'class' => 'w-48 mr-3 text-white font-semibold focus:ring-4 focus:border-2 hover:border-[#1b734a] hover:text-[#1b734a] font-medium rounded-lg text-sm px-5 py-2.5 mb-2 focus:ring-transparent ml-8 ', 
            ],
        ]);
       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
            'is_reply'=>false
            
        ]);
    }
}
