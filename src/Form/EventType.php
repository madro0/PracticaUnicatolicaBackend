<?php

namespace App\Form;

use App\Entity\Eventos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre')
            ->add('archivos')
            ->add('descripcion')
            ->add('FechaCreacion')
            ->add('FechaModificacion')
            ->add('FechaInicio')
            ->add('FechaFin')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Eventos::class,
        ]);
    }
}
