<?php

namespace App\Form;

use App\Entity\Categoria;
use App\Repository\CategoryRepositoryInterface;
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
                'label' => 'Categoría padre',
                'query_builder' => function (CategoryRepositoryInterface $categoryRepository) use ($options) {
                    $queryBuilder = $categoryRepository->createQueryBuilder('c');

                    if (array_key_exists('data', $options)) {
                        $id = [$options['data']->getId()];
                        $categories = $categoryRepository->allChildren($id);
                        $all[] = $id;

                        while (!empty($categories)) {
                            $childrenIds = array();

                            foreach ($categories as $category) {
                                $childrenIds[] = $category->getId();
                                $all[] = $category->getId();
                            }

                            $categories = $categoryRepository->allChildren($childrenIds);
                        }

                        $queryBuilder->where('c.parent NOT IN (:children)')
                            ->andWhere('c.id != :id')
                            ->setParameter('children', $all)
                            ->setParameter('id', $id);
                    }

                    $queryBuilder->orderBy('c.name', 'ASC');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categoria::class,
        ]);
    }
}
