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
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'constraints' => new Length([
                    'min' => 1,
                    "max" => 40,
                ]),
                'label' => 'First Name'
            ])
            ->add('lastname', TextType::class, [
                'constraints' => new Length([
                    'min' => 1,
                    'max' => 40,
                ]),
                'label' => 'Last Name'
            ])
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, [
                'constraints' => new Length([
                    'min' => 8,
                ]),
                'type' => PasswordType::class,
                'invalid_message' => 'Password and password confirmation fields must be the same',
                'required' => true,
                'first_options' => ['label' => 'Create a password'],
                'second_options' => ['label' => 'Confirm your password'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Register'
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
