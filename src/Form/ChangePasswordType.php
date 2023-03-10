<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                "disabled" => true,
                "label" => 'Address efefefeEmail'
            ])
          
            ->add('firstname',TextType::class,[
                "disabled" => true,
                "label" => 'My First Name '
            ])
            ->add('lastname',TextType::class,[
                "disabled" => true,
                "label" => 'My Last Name'
            ])
            ->add('old_password',PasswordType::class,[
                'mapped'=>false,
                'label'=>"My current password",
                'attr' => [
                    'placeholder' =>'Please enter current password'
                ]
            ])
            ->add('new_password', RepeatedType::class,[
                'type' =>passwordType::class,
                'mapped'=>false,
                'invalid_message' =>'Passwords does not match please try again.',
                'label'=>'My new password',
                'required' => true,
                'first_options'  => [
                    'label' => 'My new Password',
                    'attr' => [
                        'placeholder' => 'Please enter your new password' 
                    ]
                    ],
                'second_options' => [
                    'label' => 'Repeat your new Password',
                    'attr' => [
                        'placeholder' => 'Please confirm your new  password' 
                    ]],
            ])
            ->add('submit', SubmitType::class,[
                'label'=>'Update',
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
