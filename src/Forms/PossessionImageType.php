<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 3/25/2019
 * Time: 5:13 PM
 */

namespace App\Forms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PossessionImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageName', TextType::class)
            ->add('imageFile', FileType::class);
    }

}