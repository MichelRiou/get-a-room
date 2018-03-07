<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['label'=>'Nom'])
                ->add('firstName', TextType::class,['label'=>'Prénom'])
                ->add('email',RepeatedType::class,['type'=> EmailType::class,
                            'first_options'=>['label'=>'Saisir votre Email/Identifiant','required'=>true],
                            'second_options'=>['label'=>'Veuillez confirmer votre Email/Identifiant'],
                            'invalid_message'=>'La saisie n\'est pas identique'])
                ->add('plainPassword', RepeatedType::class,['type'=> PasswordType::class,
                            'first_options'=>['label'=>'Veuillez saisir le mot de passe','required'=>true],
                            'second_options'=>['label'=>'Veuillez confirmer le mot de passe'],
                            'invalid_message'=>'Le mot de passe n\'est pas identique'])
                ->add('submit',SubmitType::class,
                ['label'=>'Valider','attr'=>['class'=>'btn btn-primary']]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Customer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_customer';
    }


}
