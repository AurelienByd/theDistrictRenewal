<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresse_livraison', TextType::class, [
                'label' => 'Adresse de livraison',
                'mapped' => false
            ])
            ->add('adresse_facturation', TextType::class, [
                'label' => 'Adresse de facturation',
                'mapped' => false
            ])
            ->add('mode_paiement', ChoiceType::class, [
                'label' => 'Mode de paiement',
                'choices' => [
                    'carte bancaire' => 1,
                    'paypal' => 2,
                    'chèque' => 3
                ],
                'expanded' => true,
                'multiple' => false,
                'mapped' => false
            ])
            ->add('cgu', CheckboxType::class, [
                'label' => 'conditions générales d’utilisation',
                'mapped' => false
            ])
            ->add('commit', SubmitType::class, [
                'label' => 'Envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
