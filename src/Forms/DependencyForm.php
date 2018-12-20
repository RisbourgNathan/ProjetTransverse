<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 19/12/2018
 * Time: 15:29
 */

namespace App\Forms;
use App\Entity\OutBuilding;
use App\Entity\PossessionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DependencyForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $outb = $options['outb'];
        $builder
            ->add('outbuilding', EntityType::class, array('class' => OutBuilding::class, 'choice_label' => 'name'))
//            ->add('outbuilding', EntityType::class, array('class' => OutBuilding::class, 'multiple' => true, 'expanded' => true, 'choice_label' => 'name'))
//            ->add('outbuilding', EntityType::class, array(
//                'class' => OutBuilding::class,
//                'choices' => $outb
//            ))
            ->add('surface', TextType::class)
            ->add('description', TextType::class);
//            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
//        $resolver->setRequired('outb');
    }
}