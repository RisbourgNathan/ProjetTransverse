<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 15/11/2018
 * Time: 15:18
 */

namespace App\Forms;
use App\Entity\Agency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class AddAgencyForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('city', TextType::class)
            ->add('zip_code', NumberType::class)
            ->add('street', TextType::class)
            ->add('is_main_agency', CheckboxType::class)
            ->add('agency_cost', NumberType::class)
        ;
    }
}