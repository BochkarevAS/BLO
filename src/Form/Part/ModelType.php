<?php

namespace App\Form\Part;

use App\Entity\Part\Brand;
use App\Entity\Part\Model;
use App\Repository\Part\BrandRepository;
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
                    return $repository->setOrderBy();
                },
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

        $formModifier = function (FormInterface $form, Brand $brand = null) {
            $models = null === $brand ? [] : $brand->getModels();

            $form->add('name', EntityType::class, [
                'class'        => Model::class,
                'label'        => 'Модель',
                'choices'      => $models,
                'choice_label' => 'name',
            ]);
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getBrand());
            }
        );

        $builder->get('brand')->addEventListener(FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $brand = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $brand);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Model::class,
            'csrf_protection' => false,
        ]);
    }
}