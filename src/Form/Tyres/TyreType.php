<?php

namespace App\Form\Tyres;

use App\Entity\Tyres\Brand;
use App\Entity\Tyres\Model;
use App\Entity\Tyres\Profile\Count;
use App\Entity\Tyres\Profile\Diameter;
use App\Entity\Tyres\Profile\Height;
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
            ->add('brands', EntityType::class, [
                'class'         => Brand::class,
                'label'         => 'Производитель',
                'required'      => false,
                'choice_label'  => 'name'
            ])
            ->add('models', EntityType::class, [
                'class'         => Model::class,
                'label'         => 'Модель',
                'multiple'      => true,
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