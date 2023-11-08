<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom *'
                ]
            )
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'required' => false
                ]
            )
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => false
                ]
            )
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone *'
                ]
            )
            ->add('demande', TextareaType::class, [
                'label' => 'Votre demande',
                'required' => false
                ]
            )
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer'
                ]
            )
            ->add('erase', ResetType::class, [
                'label' => 'Annuler'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
