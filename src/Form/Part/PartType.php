<?php

namespace App\Form\Part;

use App\Entity\Part\Brand;
use App\Entity\Part\Model;
use App\Repository\Part\BrandRepository;
use App\Repository\Part\ModelRepository;
use Doctrine\ORM\EntityRepository;
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
//        $builder
//            ->add('brand', EntityType::class, [
//                'attr'          => ['class' => 'form-control'],
//                'label'         => 'Марка',
//                'choice_label'  => 'name',
//                'class'         => Brand::class,
//                'query_builder' => function (BrandRepository $repository) {
//                    return $repository->setOrderBy();
//                },
//            ])
////            ->add('model', EntityType::class, [
////                'attr'          => ['class' => 'form-control'],
////                'label'         => 'Модель',
////                'choice_label'  => 'name',
////                'class'         => Model::class,
////                'query_builder' => function (ModelRepository $repository) {
////                    return $repository->setOrderBy();
////                },
////            ])
////            ->add('engine', TextType::class, [
////                'attr' => ['class' => 'form-control'],
////                'label' => 'Двигатель',
////                'required' => false
////            ])
////            ->add('part', TextType::class, [
////                'attr' => ['class' => 'form-control'],
////                'label' => 'Номер, маркировка запчасти',
////                'required' => false
////            ])
//        ;

//        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
//            $form = $event->getForm();
//            $data = $event->getData();
//
////                var_dump($data); die;
//echo 111;
////            $sport = $data->getSport();
//            $positions = null === $data ? [] : []; // $sport->getAvailablePositions();
//
//            $form->add('model', EntityType::class, [
//                'class'         => Model::class,
//                'attr'          => ['class' => 'form-control'],
//                'label'         => 'Модель',
//                'choice_label'  => 'name',
//                'choices'       => $positions,
//            ]);
//            }
//        );

//        $builder
//            ->add('name')
//            ->add('brand', EntityType::class, [
//                'class'        => Brand::class,
//                'choice_label' => 'name',
//            ])
//        ;

        $builder->add('price');

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            // проверьте, является ли объект Продукт "новым"
            // Если в форму не были переданы данные, то данные - "null".
            // Это должно быть воспринято, как новый "Продукт"
            if (!$data || null === $data->getId()) {
                $form->add('name', TextType::class);
            }
        });




//        $formModifier = function (FormInterface $form, Brand $brand) {
//            $models = null === $brand ? [] : $brand->getModels();
//
//            $form->add('model', EntityType::class, [
//                'class'    => Model::class,
//                'choices'  => $models,
//            ]);
//        };
//
//        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifier) {
//            $data = $event->getData();
//
//            var_dump($event->getData()); die;
//
//            $formModifier($event->getForm(), $data->getBrand());
//            }
//        );
//
//        $builder->get('brand')->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($formModifier) {
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