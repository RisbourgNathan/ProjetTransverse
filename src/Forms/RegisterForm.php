<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 14/11/2018
 * Time: 17:37
 */

namespace App\Forms;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegisterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_attr' => ['class' => 'sr-only', 'for' => 'inputEmail'],
                'attr' => ['class' => 'form-control', 'placeholder' => 'Email', 'id' => 'inputEmail'],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'label_attr' => ['class' => 'sr-only', 'for' => 'inputFirstName'],
                'attr' => ['class' => 'form-control', 'placeholder' => 'Prénom', 'id' => 'inputFirstName'],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'label_attr' => ['class' => 'sr-only', 'for' => 'inputName'],
                'attr' => ['class' => 'form-control', 'placeholder' => 'Nom', 'id' => 'inputNae'],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'label_attr' => ['class' => 'sr-only', 'for' => 'inputCity'],
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ville', 'id' => 'inputCity'],
            ])
            ->add('zipcode', NumberType::class, [
                'label' => 'Code postal',
                'label_attr' => ['class' => 'sr-only', 'for' => 'inputPostalCode'],
                'attr' => ['class' => 'form-control', 'placeholder' => 'Code Postal', 'id' => 'inputPostalCode'],
            ])
            ->add('street', TextType::class, [
                'label' => 'Rue',
                'label_attr' => ['class' => 'sr-only', 'for' => 'inputStreet'],
                'attr' => ['class' => 'form-control', 'placeholder' => 'Rue', 'id' => 'inputStreet'],
            ])
            ->add('phone', NumberType::class,[
                'label' => 'Numéro de téléphone',
                'label_attr' => ['class' => 'sr-only', 'for' => 'inputPhone'],
                'attr' => ['class' => 'form-control', 'placeholder' => 'Numéro de téléphone', 'id' => 'inputPhone'],
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe', 'label_attr' => ['class' => 'sr-only', 'for' => 'password'], 'attr' => ['class' => 'form-control', 'placeholder' => 'Mot de passe', 'id' => 'password']),
                'second_options' => array('label' => 'Répéter le mot de passe', 'label_attr' => ['class' => 'sr-only', 'for' => 'inputSecondPassword'], 'attr' => ['class' => 'form-control', 'placeholder' => 'Répéter le mot de passe', 'id' => 'inputSecondPassword']),
            ))
            ->add('sponsorCode', TextType::class, [
                'label' => 'Code de parrainage',
                'required' => false,
                'mapped' => false,
                'label_attr' => ['class' => 'sr-only', 'for' => 'inputSponsorCode'],
                'attr' => ['class' => 'form-control', 'placeholder' => 'Code de parrainage', 'id' => 'inputSponsorCode'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}
