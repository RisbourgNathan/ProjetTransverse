<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 25/03/2019
 * Time: 17:31
 */

namespace App\Forms;
use App\Entity\Possession;
use App\Entity\PossessionType;
use App\Repository\PossessionTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type',EntityType::class,[
                'class' => PossessionType::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'multiple'=> true,
                'expanded'=> true,
                'label' => 'Type d\'annonce : '
            ])
            ->add('city', TextType::class,[
                'label' => 'Ville : ',
                'required' => false
            ])
            ->add('price', RangeType::class,[
                'attr' => [
                    'min' => 0,
                    'max' => 500000,
                    'class' => "priceSlider"
                ],
                'label' => "Prix : "
            ])
            ->add('Valider', SubmitType::class);
    }
}