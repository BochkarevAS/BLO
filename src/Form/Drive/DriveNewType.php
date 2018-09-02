<?php

namespace App\Form\Drive;

use App\Entity\Client\Availability;
use App\Entity\Client\Company;
use App\Entity\Client\Condition;
use App\Entity\Drives\Drive;
use App\Entity\Region\City;
use App\Entity\Drives\Brand;
use App\Entity\Drives\Model;
use App\Repository\Drive\ModelRepository;
use App\Repository\Client\CompanyRepository;
use App\Repository\Region\CityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DriveNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $diameters  = array_combine(range(4, 55, 0.5), range(4, 55, 0.5));
        $departures = array_combine(range(-20, 125, 1), range(-20, 125, 1));
        $widths     = array_combine(range(4, 15, 0.5), range(4, 15, 0.5));

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

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();

                /* @var Brand $brand */
                $brand = $data->getBrand();
                $form  = $event->getForm();

                if ($brand) {
                    $this->formModel($form, $brand);
                } else {
                    $this->formModel($form, null);
                }
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
            'data_class'      => Drive::class,
            'csrf_protection' => false,
        ]);
    }
}