<?php

namespace App\Form\Part;

use App\Entity\Parts\Brand;
use App\Entity\Parts\Carcase;
use App\Entity\Parts\Model;
use App\Repository\Parts\BrandRepository;
use App\Repository\Parts\ModelRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand', EntityType::class, [
                'class'         => Brand::class,
                'label'         => 'Марка',
                'choice_label'  => 'name',
                'query_builder' => function (BrandRepository $repository) {
                    return $repository->orderBy();
                },
            ])
            ->add('name', EntityType::class, [
                'class'         => Model::class,
                'label'         => 'Модель',
                'query_builder' => function (ModelRepository $repository) {
                    return $repository->orderBy();
                },
            ])
            ->add('carcases', EntityType::class, [
                'class'        => Carcase::class,
                'label'        => 'Кузов',
            ])
            ->add('engines', TextType::class, [
                'attr'     => ['class' => 'form-control'],
                'label'    => 'Двигатель',
                'required' => false
            ])
            ->add('parts', TextType::class, [
                'attr'     => ['class' => 'form-control'],
                'label'    => 'Номер, маркировка запчасти',
                'required' => false
            ])
        ;

//        $formModifier = function (FormInterface $form, Brand $brand = null) {
//            $models = null === $brand ? [] : $brand->getModels();
//
//            $form->add('name', EntityType::class, [
//                'class'        => Model::class,
//                'label'        => 'Модель',
//                'choices'      => $models,
//            ]);
//
//            $form->add('carcases', EntityType::class, [
//                'class'        => Carcase::class,
//                'label'        => 'Кузов',
//            ]);
//        };
//
//        $builder->addEventListener(FormEvents::PRE_SET_DATA,
//            function (FormEvent $event) use ($formModifier) {
//                $data = $event->getData();
//                $formModifier($event->getForm(), $data->getBrand());
//            }
//        );
//
//        $builder->get('brand')->addEventListener(FormEvents::POST_SUBMIT,
//            function (FormEvent $event) use ($formModifier) {
//                $brand = $event->getForm()->getData();
//                $formModifier($event->getForm()->getParent(), $brand);
//            }
//        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Model::class,
            'csrf_protection' => false,
        ]);
    }
}