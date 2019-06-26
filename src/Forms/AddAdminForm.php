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

/**
 * Class AddAdminForm
 * @package App\Forms
 */
class AddAdminForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',EntityType::class, array('class' => User::class, 'choice_label' => 'email'))
        ;
    }
}
