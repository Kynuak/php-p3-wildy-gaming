<?php

namespace App\Form;

use App\Entity\Lot;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => ['placeholder' => 'Prénom', 'class' => 'monprofil'],
                'label' => false
            ])
            ->add('lastname', TextType::class, [
                'attr' => ['placeholder' => 'Nom', 'class' => 'monprofil'],
                'label' => false
            ])
            ->add('username', TextType::class, [
                'attr' => ['placeholder' => 'Pseudo', 'class' => 'monprofil'],
                'label' => false
            ])
            ->add('birthdate', DateType::class, [
                'attr' => ['class' => 'birthdate'],
                'label' => false,
                'years' => range(date('Y') - 18, date('Y') - 100),
            ])

            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => 'Email', 'class' => 'monprofil'],
                'label' => false
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
