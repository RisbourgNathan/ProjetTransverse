<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 16/11/2018
 * Time: 14:17
 */

namespace App\Forms;
use App\Entity\Agency;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class AddAgentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',EntityType::class, array('class' => User::class, 'choice_label' => 'email'))
            ->add('agency',EntityType::class, array('class' => Agency::class, 'choice_label' => 'name'))
        ;
    }
}