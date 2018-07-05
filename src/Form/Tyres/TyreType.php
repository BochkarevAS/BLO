<?php

namespace App\Form\Tyres;

use App\Entity\Tyres\Manufacturer;
use App\Entity\Tyres\Model;
use App\Entity\Tyres\Seasonality;
use App\Entity\Tyres\Thorn;
use App\Entity\Tyres\Tyre;
use App\Entity\Tyres\Vendor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TyreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('manufacturers', EntityType::class, [
                'class'         => Manufacturer::class,
                'label'         => 'Производитель',
                'choice_label'  => 'name',
                'choice_value'  => 'id',
            ])
            ->add('model', EntityType::class, [
                'class'         => Model::class,
                'label'         => 'Модель',
                'multiple'      => true,
                'mapped'        => false,
                'choice_label'  => 'name',
            ])
            ->add('vendors', EntityType::class, [
                'class'         => Vendor::class,
                'label'         => 'Продавец',
                'multiple'      => true,
                'choice_label'  => 'name',
            ])
            ->add('thorns', EntityType::class, [
                'class'         => Thorn::class,
                'label'         => 'Шипы',
                'choice_label'  => 'name',
            ])
            ->add('seasonalitys', EntityType::class, [
                'class'         => Seasonality::class,
                'label'         => 'Сезонность',
                'choice_label'  => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Tyre::class,
            'csrf_protection' => false,
        ]);
    }
}