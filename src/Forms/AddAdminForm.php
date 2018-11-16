<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 16/11/2018
 * Time: 14:28
 */

namespace App\Forms;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddAdminForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',EntityType::class, array('class' => User::class, 'choice_label' => 'email'))
        ;
    }
}