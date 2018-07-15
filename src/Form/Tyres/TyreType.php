<?php

namespace App\Form\Tyres;

use App\Entity\Tyres\Brand;
use App\Entity\Tyres\Model;
use App\Entity\Tyres\Seasonality;
use App\Entity\Tyres\Thorn;
use App\Entity\Tyres\Tyre;
use App\Entity\Tyres\Vendor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TyreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $widths    = [];
        $heights   = [];
        $quantitys = [];
        $diameters = [];

        for ($i = 105; $i <= 815; $i = $i + 5) {
            $widths[$i] = $i;
        }
        for ($i = 25; $i <= 110; $i = $i + 5) {
            $heights[$i] = $i;
        }
        for ($i = 1; $i <= 10; $i++) {
            $quantitys[$i] = $i;
        }
        for ($i = 6; $i <= 57; $i = $i + 0.5) {
            $diameters[] = $i;
        }

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
            ->add('diameter', ChoiceType::class, [
                'choices'  => $diameters,
                'label'    => 'Диаметр',
                'required' => false
            ])
            ->add('height', ChoiceType::class, [
                'choices'  => $heights,
                'label'    => 'Высота',
                'required' => false
            ])
            ->add('width', ChoiceType::class, [
                'choices'  => $widths,
                'label'    => 'Ширина',
                'required' => false
            ])
            ->add('quantity', ChoiceType::class, [
                'choices'  => $quantitys,
                'label'    => 'Количество',
                'required' => false
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