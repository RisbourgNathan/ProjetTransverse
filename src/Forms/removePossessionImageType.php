<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 3/27/2019
 * Time: 3:47 PM
 */

namespace App\Forms;


use App\Entity\PossessionImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class removePossessionImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('remove', SubmitType::class);
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'data_class' => PossessionImage::class,
//        ]);
//    }
}