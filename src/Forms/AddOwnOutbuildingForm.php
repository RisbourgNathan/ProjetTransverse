<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 12/21/2018
 * Time: 2:34 PM
 */

namespace App\Forms;


use App\Entity\OutBuilding;
use App\Entity\OwnOutBuilding;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddOwnOutbuildingForm
 * @package App\Forms
 */
class AddOwnOutbuildingForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('outbuilding', EntityType::class, array('class' => OutBuilding::class, 'choice_label' => 'name', 'label' => 'Nom'))
            ->add('surface', TextType::class, [
                'label' => 'Surface'
            ])
            ->add('description', TextType::class, [
                'label' => 'Description'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => OwnOutBuilding::class,
        ));
    }
}
