<?php


namespace App\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class HomeSearchForm
 * @package App\Forms
 */
class HomeSearchForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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
