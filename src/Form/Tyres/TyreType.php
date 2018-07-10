<?php

namespace App\Form\Tyres;

use App\Entity\Tyres\Manufacturer;
use App\Entity\Tyres\Model;
use App\Entity\Tyres\Profile\ProfileAvailability;
use App\Entity\Tyres\Profile\Count;
use App\Entity\Tyres\Profile\Diameter;
use App\Entity\Tyres\Profile\Height;
use App\Entity\Tyres\Profile\ProfileStatus;
use App\Entity\Tyres\Profile\Width;
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
                'required'      => false,
                'choice_label'  => 'name'
            ])
            ->add('model', EntityType::class, [
                'class'         => Model::class,
                'label'         => 'Модель',
                'multiple'      => true,
                'mapped'        => false,
                'required'      => false,
                'choice_label'  => 'name',
            ])
            ->add('vendors', EntityType::class, [
                'class'         => Vendor::class,
                'label'         => 'Продавец',
                'multiple'      => true,
                'required'      => false,
                'choice_label'  => 'name',
            ])
            ->add('thorns', EntityType::class, [
                'class'         => Thorn::class,
                'label'         => 'Шипы',
                'required'      => false,
                'choice_label'  => 'name',
            ])
            ->add('seasonalitys', EntityType::class, [
                'class'         => Seasonality::class,
                'label'         => 'Сезонность',
                'required'      => false,
                'choice_label'  => 'name',
            ])
            ->add('diameters', EntityType::class, [
                'class'         => Diameter::class,
                'label'         => 'Диаметр',
                'required'      => false,
                'choice_label'  => 'name',
            ])
            ->add('heights', EntityType::class, [
                'class'         => Height::class,
                'label'         => 'Высота',
                'required'      => false,
                'choice_label'  => 'name',
            ])
            ->add('widths', EntityType::class, [
                'class'         => Width::class,
                'label'         => 'Ширина',
                'required'      => false,
                'choice_label'  => 'name',
            ])
            ->add('counts', EntityType::class, [
                'class'         => Count::class,
                'label'         => 'Количество',
                'required'      => false,
                'choice_label'  => 'name',
            ])
            ->add('status', EntityType::class, [
                'class'         => ProfileStatus::class,
                'label'         => 'Состояние',
                'mapped'        => false,
                'required'      => false,
                'choice_label'  => 'name',
            ])
            ->add('availability', EntityType::class, [
                'class'         => ProfileAvailability::class,
                'label'         => 'Наличие',
                'mapped'        => false,
                'required'      => false,
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