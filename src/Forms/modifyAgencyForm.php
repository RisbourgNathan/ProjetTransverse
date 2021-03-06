<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 20/12/2018
 * Time: 15:26
 */

namespace App\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

/**
 * Class modifyAgencyForm
 * @package App\Forms
 */
class modifyAgencyForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('city', TextType::class)
            ->add('zip_code', NumberType::class)
            ->add('phone',NumberType::class)
            ->add('street', TextType::class)
            ->add('is_main_agency', CheckboxType::class)
            ->add('agency_cost', NumberType::class)
        ;
    }
}
