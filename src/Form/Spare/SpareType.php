<?php

namespace App\Form\Spare;

use App\Entity\Spare\Mark;
use App\Entity\Spare\Model;
use App\Repository\Spare\MarkRepository;
use App\Repository\Spare\ModelRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpareType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mark', EntityType::class, [
                'attr'          => ['class' => 'form-control'],
                'label'         => 'Марка',
                'choice_label'  => 'name',
                'class'         => Mark::class,
                'query_builder' => function (MarkRepository $repository) {
                    return $repository->setOrderBy();
                },
            ])
            ->add('model', EntityType::class, [
                'attr'          => ['class' => 'form-control'],
                'label'         => 'Модель',
                'choice_label'  => 'name',
                'class'         => Model::class,
                'query_builder' => function (ModelRepository $repository) {
                    return $repository->setOrderBy();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Mark::class,
            'csrf_protection' => false,
        ]);
    }
}