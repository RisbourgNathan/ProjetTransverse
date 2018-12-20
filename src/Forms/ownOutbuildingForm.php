<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 12/20/2018
 * Time: 3:46 PM
 */

namespace App\Forms;


use App\Entity\OutBuilding;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ownOutbuildingForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $outbuilding = $options['outbuilding'];
        $builder
            ->add('outbuilding', EntityType::class, array(
                'class' => OutBuilding::class,
                'choices' => $outbuilding,
                'choice_label' => 'name'
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('outbuilding');
    }
}