<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 5/22/2019
 * Time: 11:04 AM
 */

namespace App\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class PropositionForm
 * @package App\Forms
 */
class PropositionForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('price', TextType::class, [
            'label' => 'Prix',
            'label_attr' => ['class' => 'sr-only', 'for' => 'inputPrice'],
            'attr' => ['class' => 'form-control', 'placeholder' => 'Prix', 'id' => 'inputPrice'],
        ])
        ->add('submit', SubmitType::class, [
        'label' => 'Valider'
    ])
    ;
    }
}
