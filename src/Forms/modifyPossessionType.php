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

/**
 * Class modifyPossessionType
 * @package App\Forms
 */
class modifyPossessionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seller', EntityType::class, array(
                'class' => Client::class,
                'choice_label' => 'user.firstName',
                'label' => 'Vendeur'

            ))
            ->add('title', TextType::class,[
                'label' => 'Titre'
            ])
            ->add('surface', IntegerType::class,[
                'label' => 'Surface'
            ])
            ->add('RoomNumber', IntegerType::class,[
                'label' => 'Nombre de pièces'
            ])
            ->add('floorNumber', IntegerType::class,[
                'label' => 'Nombre d\'étages'
            ])
            ->add('description', TextType::class,[
                'label' => 'Description'
            ])
            ->add('selling_price', NumberType::class,[
                'label' => 'Prix de vente'
            ])
            ->add('validation_state', TextType::class,[
                'label' => 'Etat de validation'
            ])
            ->add('city', TextType::class,[
                'label' => 'Ville'
            ])
            ->add('zip_code', TextType::class,[
                'label' => 'Code postal'
            ])
            ->add('street', TextType::class,[
                'label' => 'Rue'
            ])
            ->add('orientation',TextType::class,[
                'label' => 'Orientation'
            ])
            ->add('constructionDate', NumberType::class,[
                'label' => 'Année de construction'
            ])
            ->add('type',EntityType::class, array('class' => PossessionType::class, 'choice_label' => 'name'))
            ->add('submit', SubmitType::class)
        ;

        $builder
            ->add('ownoutbuilding', CollectionType::class, array(
                'entry_type' => AddOwnOutbuildingForm::class,
                'entry_options' => array('label' => 'Dépendances'),
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Dépendance'
            ));

        $builder
            ->add('possessionImage', CollectionType::class, array(
                'entry_type' => PossessionImageType::class,
//                'entry_options' => array('label' => false),
                'required' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Image'
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
