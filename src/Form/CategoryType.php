<?php

namespace App\Form;

use App\Entity\Categoria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Nombre'
            ])
            ->add('description', null, [
                'required' => false,
                'label' => 'Descripción'
            ])
            ->add('parent', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'required' => false,
                'label' => 'Categoría padre'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categoria::class,
        ]);
    }
}
