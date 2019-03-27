<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 3/25/2019
 * Time: 5:13 PM
 */

namespace App\Forms;


use App\Entity\PossessionImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PossessionImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('imageName', TextType::class, [
//                'required' => false,
//                'label' => 'Image Name: '
//            ])
            ->add('description', TextType::class, [
                'required' => false,
                'label' => 'Description: '
            ])
            ->add('imageFile', FileType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PossessionImage::class,
        ]);
    }
}