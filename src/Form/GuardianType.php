<?php

namespace App\Form;

use App\Entity\Opinions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuardianType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('coment', TextType::class, [
                'label' => 'Comentario',
                'required' => true,
                'attr' => ['placeholder' => 'Añade tu comentario']
            ])
            ->add('author', TextType::class, [
                'label' => 'Autor',
                'required' => true,
                'attr' => ['placeholder' => 'Ej. John Doe']
            ])
            ->add('city', TextType::class, [
                'label' => 'Ciudad',
                'required' => true
            ])
            ->add('enviar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Opinions::class,
        ]);
    }
}
