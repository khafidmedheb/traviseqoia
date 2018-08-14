<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Classee "builder" du formulaire de contact.
 */
class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('attr' => array('placeholder' => 'Votre nom'),
                   'constraints' => array(
                       new NotBlank(array('message' => 'Merci de renseigner votre nom')),
                   ),
               ))
            ->add('sujet', TextType::class, array('attr' => array('placeholder' => 'Sujet'),
                  'constraints' => array(
                      new NotBlank(array('message' => 'Merci de laisser un sujet')),
                  ),
              ))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Votre adresse email'),
                  'constraints' => array(
                      new NotBlank(array('message' => 'Merci de fournir un email valide')),
                      new Email(array('message' => "Votre email n'est pas valide")),
                  ),
              ))
            ->add('message', TextareaType::class, array('attr' => array('placeholder' => 'Votre message ici'),
                  'constraints' => array(
                      new NotBlank(array('message' => 'Laisser un message ici')),
                  ),
              ));
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault(array(
            'error_building' => true,
        ));
    }

    public function getNom()
    {
        return 'contact_form';
    }
}
