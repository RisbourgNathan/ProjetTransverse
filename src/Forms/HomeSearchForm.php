<?php


namespace App\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomeSearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'label_attr' => ['class' => 'sr-only', 'for' => 'inputCity'],
                'attr' => ['class' => 'form-control', 'placeholder' => 'Rechercher une ville', 'id' => 'inputCity'],
            ])
            ->add('Rechercher', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => ['class' => 'btn btn-primary']
            ])
            ->setMethod('POST');
    }
}
