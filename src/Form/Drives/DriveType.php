<?php

namespace App\Form\Drives;

use App\Entity\Client\Availability;
use App\Entity\Client\Company;
use App\Entity\Client\Condition;
use App\Entity\Drives\Brand;
use App\Entity\Drives\Drive;
use App\Entity\Drives\Model;
use App\Entity\Region\City;
use App\Repository\Client\CompanyRepository;
use App\Repository\Region\CityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DriveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        for ($i = 4; $i <= 55; $i = $i + 0.5) {
            $diameters[(string) $i] = $i;
        }

        for ($i = -20; $i <= 125; $i++) {
            $departures[(string) $i] = $i;
        }

        for ($i = 4; $i <= 15; $i = $i + 0.5) {
            $widths[(string) $i] = $i;
        }

        $builder
            ->add('brand', EntityType::class, [
                'label'         => 'Производитель',
                'class'         => Brand::class,
                'choice_label'  => 'name',
                'required'      => false
            ])
            ->add('model', EntityType::class, [
                'label'         => 'Модель',
                'class'         => Model::class,
                'choice_label'  => 'name',
                'required'      => false
            ])
            ->add('diameter', ChoiceType::class, [
                'label'    => 'Диаметр',
                'choices'  => $diameters,
                'required' => false
            ])
            ->add('departure', ChoiceType::class, [
                'label'    => 'Вылет',
                'choices'  => $departures,
                'required' => false
            ])
            ->add('width', ChoiceType::class, [
                'label'    => 'Ширина',
                'choices'  => $widths,
                'required' => false
            ])
            ->add('availability',EntityType::class, [
                'class'        => Availability::class,
                'choice_label' => 'name',
                'label'        => 'Наличие',
                'placeholder'  => 'Все',
                'multiple'     => false,
                'required'     => false,
                'expanded'     => true,
            ])
            ->add('condition', EntityType::class, [
                'class'        => Condition::class,
                'choice_label' => 'name',
                'label'        => 'Состояние',
                'placeholder'  => 'Все',
                'multiple'     => false,
                'required'     => false,
                'expanded'     => true
            ])
            ->add('company', EntityType::class, [
                'class'         => Company::class,
                'label'         => 'Продавец',
                'choice_label'  => 'name',
                'required'      => false,
                'query_builder' => function (CompanyRepository $repository) {
                    return $repository->orderBy();
                }
            ])
            ->add('city', EntityType::class, [
                'class'         => City::class,
                'label'         => 'Город',
                'choice_label'  => 'name',
                'required'      => false,
                'query_builder' => function (CityRepository $repository) {
                    return $repository->orderBy();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Drive::class,
            'csrf_protection' => false,
        ]);
    }
}