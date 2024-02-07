<?php

namespace App\Form;

use App\Entity\Lot;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['placeholder' => 'Titre', 'class' => 'inputneonpurple'],
                'label' => false])
            ->add('price', ChoiceType::class, [
                'choices' => [
                    '50' => 50,
                    '250' => 250,
                    '450' => 450,
                    '650' => 650,
                    '850' => 850,
                ],
                'multiple' => false,
                'expanded' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prix', 
                    'class' => 'inputneonpurple'
                ],
                ])
            ->add('imageFile', VichFileType::class, [
                'label' => false,
                'required'      => false,
                'allow_delete'  => true, 
                'download_uri' => true,
                'attr' => [
                    'placeholder' => 'Fichier', 
                    'class' => 'inputneonpurple'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lot::class,
        ]);
    }
}
