<?php

namespace App\Form\Tyre;

use App\Entity\Client\Availability;
use App\Entity\Client\Company;
use App\Entity\Client\Condition;
use App\Entity\Region\City;
use App\Entity\Tyres\Brand;
use App\Entity\Tyres\Model;
use App\Entity\Tyres\Seasonality;
use App\Entity\Tyres\Thorn;
use App\Entity\Tyres\Tyre;
use App\Repository\Client\CompanyRepository;
use App\Repository\Region\CityRepository;
use App\Repository\Tyre\ModelRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TyreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $widths    = array_combine(range(105, 815, 5), range(105, 815, 5));
        $heights   = array_combine(range(25, 110, 5), range(25, 110, 5));
        $quantitys = array_combine(range(1, 10, 1), range(1, 10, 1));
        $diameters = array_combine(range(6, 57, 0.5), range(6, 57, 0.5));

        $builder
            ->add('brand', EntityType::class, [
                'class'         => Brand::class,
                'label'         => 'Производитель',
                'required'      => false,
                'choice_label'  => 'name'
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
            ->add('thorn', EntityType::class, [
                'class'         => Thorn::class,
                'label'         => 'Шипы',
                'required'      => false,
                'choice_label'  => 'name'
            ])
            ->add('seasonality', EntityType::class, [
                'class'         => Seasonality::class,
                'label'         => 'Сезонность',
                'required'      => false,
                'choice_label'  => 'name'
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
                'required' => false,
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
        ;

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->formModel($form, null);
            }
        );

        $builder->get('brand')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->formModel($form->getParent(), $form->getData());
            }
        );
    }

    private function formModel(FormInterface $form, ?Brand $brand = null)
    {
        $form->add('model', EntityType::class, [
            'class'           => Model::class,
            'label'           => 'Модель',
            'multiple'        => true,
            'required'        => false,
            'auto_initialize' => false,
            'choices'         => $brand ? $brand->getModels() : [],
            'query_builder'   => function (ModelRepository $repository) {
                return $repository->orderBy();
            }
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Tyre::class,
            'csrf_protection' => false,
        ]);
    }
}