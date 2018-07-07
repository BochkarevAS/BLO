<?php

namespace App\Form\Parts;

use App\Entity\Parts\Brand;
use App\Entity\Parts\Carcase;
use App\Entity\Parts\Model;
use App\Entity\Parts\Part;
use App\Entity\Region\City;
use App\Repository\Parts\BrandRepository;
use App\Repository\Parts\CityRepository;
use App\Repository\Parts\PartRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city', EntityType::class, [
                'class'         => City::class,
                'label'         => 'Город',
                'choice_label'  => 'name',
                'mapped'        => false,
                'query_builder' => function (CityRepository $repository) {
                    return $repository->orderBy();
                },
            ])
            ->add('brand', EntityType::class, [
                'class'         => Brand::class,
                'label'         => 'Марка',
                'choice_label'  => 'name',
                'mapped'        => false,
                'required'      => false,
                'query_builder' => function (BrandRepository $repository) {
                    return $repository->orderBy();
                },
            ])
            ->add('oem', TextType::class, [
                'attr'     => ['class' => 'form-control'],
                'label'    => 'OEM, артикул',
                'required' => false
            ])
            ->add('engines', TextType::class, [
                'attr'     => ['class' => 'form-control'],
                'label'    => 'Двигатель',
                'required' => false
            ])
            ->add('name', TextType::class, [
                'attr'     => ['class' => 'form-control'],
                'label'    => 'Номер, маркировка запчасти',
                'required' => false
            ])
        ;

        $builder->get('brand')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->formModel($form->getParent(), $form->getData());
            }
        );

        $builder->addEventListener(FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();
                $model = $data->getModels()->current();

                dump($model);
                dump($event->getForm());

                if ($model) {
                    $carcase = $model->getCarcase();
                    $brand   = $carcase->getBrand();

                    $this->formModel($form, $brand);
                    $this->formCarcase($form, $carcase);

                    $form->get('carcase')->setData($carcase);
                    $form->get('brand')->setData($brand);
                } else {
                    $this->formModel($form, null);
                    $this->formCarcase($form, null);
                }
            }
        );
    }

    private function formModel(FormInterface $form, ?Brand $brand = null)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'model',
            EntityType::class,
            null,
            [
                'class'           => Model::class,
                'label'           => 'Модель',
                'mapped'          => false,
                'required'        => false,
                'auto_initialize' => false,
                'choices'         => $brand ? $brand->getModel() : [],
            ]
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->formCarcase($form->getParent(), $form->getData());
            }
        );

        $form->add($builder->getForm());
    }

    private function formCarcase(FormInterface $form, ?Model $model = null)
    {
        $form->add('carcase', EntityType::class, [
                'class'           => Carcase::class,
                'label'           => 'Кузов',
                'mapped'          => false,
                'required'        => false,
                'auto_initialize' => false,
                'choices'         => $model ? $model->getCarcase() : [],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Part::class,
            'csrf_protection' => false,
        ]);
    }
}