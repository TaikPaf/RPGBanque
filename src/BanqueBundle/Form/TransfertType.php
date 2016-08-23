<?php

namespace BanqueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransfertType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('somme')
            ->add('motif')
            ->add('crediteur', EntityType::class, array(
                // query choices from this entity
                'class' => 'BanqueBundle:CompteCourant',

                // use the User.username property as the visible option string
                'choice_label' => 'user.username',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ))
            ->add('debiteur', EntityType::class, array(
                // query choices from this entity
                'class' => 'BanqueBundle:CompteCourant',

                // use the User.username property as the visible option string
                'choice_label' => 'user.username',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BanqueBundle\Entity\Transfert'
        ));
    }
}
