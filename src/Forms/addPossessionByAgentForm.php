<?php

namespace App\Forms;


use App\Entity\Agent;
use App\Entity\Client;
use App\Entity\PossessionType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class addPossessionByAgentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $clients = $options['clients'];

        $builder
            ->add('seller',EntityType::class, array(
                'class' => Client::class,
                'choices' => $clients,
                'choice_label'  => function(Client $client) {
                    $user = $client->getUser();
                    return $user->getLastname() . " " . $user->getFirstname();
                }))
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
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('clients');
    }
}