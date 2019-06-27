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

/**
 * Class ownOutbuildingForm
 * @package App\Forms
 */
class ownOutbuildingForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $outbuilding = $options['outbuilding'];
        $builder
            ->add('outbuilding', EntityType::class, array(
                'class' => OutBuilding::class,
                'choices' => $outbuilding,
                'choice_label' => 'name',
                'label' => 'Nom'
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('outbuilding');
    }
}
