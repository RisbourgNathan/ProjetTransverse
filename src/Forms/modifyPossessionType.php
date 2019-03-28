<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 3/27/2019
 * Time: 2:03 PM
 */

namespace App\Forms;


use App\Entity\Client;
use App\Entity\PossessionImage;
use App\Entity\PossessionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class modifyPossessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seller', EntityType::class, array(
                'class' => Client::class,
                'choice_label' => 'user.firstName'
            ))
            ->add('title', TextType::class)
            ->add('surface', IntegerType::class)
            ->add('RoomNumber', IntegerType::class)
            ->add('floorNumber', IntegerType::class)
            ->add('description', TextType::class)
            ->add('selling_price', NumberType::class)
            ->add('validation_state', TextType::class)
            ->add('city', TextType::class)
            ->add('zip_code', TextType::class)
            ->add('street', TextType::class)
            ->add('picture_path', TextType::class)
            ->add('type',EntityType::class, array('class' => PossessionType::class, 'choice_label' => 'name'))
            ->add('submit', SubmitType::class)
        ;

        $builder
            ->add('ownoutbuilding', CollectionType::class, array(
                'entry_type' => AddOwnOutbuildingForm::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete' => true,
            ));

        $builder
            ->add('possessionImage', CollectionType::class, array(
                'entry_type' => PossessionImageType::class,
//                'entry_options' => array('label' => false),
                'required' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ));

//        $builder
//            ->add('possessionImage', EntityType::class, [
//                'class' => PossessionImage::class,
//                'choice_label' => 'description',
//                'choice_value' => 'id',
//                'multiple' => true,
//                'expanded' => true,
//                'label' => 'Supprimer'
//            ]);
    }

}