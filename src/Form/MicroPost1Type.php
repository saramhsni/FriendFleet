<?php

namespace App\Form;

use App\Entity\MicroPost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MicroPost1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',null,[
                'label_attr'=> ['class'=>'block text-gray-700 text-sm font-bold mb-2'],
                'attr'=>['class'=>'shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']
            ])
            ->add('text',null,[
                'label_attr'=> ['class'=>'block text-gray-700 text-sm font-bold mb-2'],
                'attr'=>['class'=>'shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']
            ])
            ->add('author', null,[
                'label_attr'=> ['class'=>'block text-gray-700 text-sm font-bold mb-2'],
                'attr'=>['class'=>'shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']
            ])
            ->add('postImage', FileType::class, [
                'label' => 'Post image (JPG or PNG file)',
                'mapped' => false,
                'required' => false,
                'constraints' =>[
                   new File([
                        'maxSize'=>'5000K',
                        'mimeTypes'=>[
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage'=>'Please Upload a PNG/JPEG image'
                   ]) 
                ]

            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MicroPost::class,
        ]);
    }
}
