<?php

namespace App\Form\Parts;

use App\Entity\Client\Company;
use App\Entity\Parts\Brand;
use App\Entity\Parts\Carcase;
use App\Entity\Parts\Model;
use App\Entity\Parts\Part;
use App\Entity\Region\City;
use App\Repository\Client\CompanyRepository;
use App\Repository\Parts\BrandRepository;
use App\Repository\Region\CityRepository;
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
            ->add('brand', EntityType::class, [
                'class'         => Brand::class,
                'label'         => 'Марка',
                'choice_label'  => 'name',
                'required'      => false,
                'query_builder' => function (BrandRepository $repository) {
                    return $repository->orderBy();
                }
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
            ->add('name', TextType::class, [
                'label'    => 'Номер, маркировка запчасти',
                'required' => false
            ])
            ->add('engine', TextType::class, [
                'label'    => 'Двигатель',
                'mapped'   => false,
                'required' => false
            ])
            ->add('oem', TextType::class, [
                'label'    => 'OEM, артикул',
                'mapped'   => false,
                'required' => false
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
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form  = $event->getForm();
                $this->formModel($form, null);
                $this->formCarcase($form, null);
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
                'choices'         => $brand ? $brand->getModels() : [],
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
                'choices'         => $model ? $model->getCarcases() : [],
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