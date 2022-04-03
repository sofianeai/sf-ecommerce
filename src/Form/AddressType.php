<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Give a name to your address',
                'required' => true,
                'attr' => [
                    'placeholder' => 'ex. Home',
                ],
            ])
            ->add('first_name', TextType::class, [
                'label' => 'First name',
                'required' => true,
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Last name',
                'required' => true,
            ])
            ->add('company', TextType::class, [
                'label' => 'Your company (Optional)',
                'required' => false,
            ])
            ->add('address', TextType::class, [
                'label' => 'Your address',
                'required' => true,
            ])
            ->add('postal_code', TextType::class, [
                'label' => 'Postal code',
                'required' => true,
            ])
            ->add('city', TextType::class, [
                'label' => 'Your city',
                'required' => true,
            ])
            ->add('country', CountryType::class, [
                'label' => 'Your country',
                'required' => true,
            ])
            ->add('phone_number', TelType::class, [
                'label' => 'Your phone number',
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
                'attr' => [
                    'class' => 'btn btn-block btn-info',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
