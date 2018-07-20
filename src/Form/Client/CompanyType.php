<?php

namespace App\Form\Client;

use App\Entity\Client\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city', TextType::class, [
                'label' => 'Город'
            ])
            ->add('name', TextType::class, [
                'label' => 'Название компании'
            ])
            ->add('syte', TextType::class, [
                'label' => 'Сайт'
            ])
            ->add('office', TextType::class, [
                'label' => 'Головной офис'
            ])
            ->add('info', TextareaType::class, [
                'label' => 'Краткая информация о компании',
            ])
            ->add('sectionsParts', CheckboxType::class, [
                'label'    => 'Запчасти',
                'required' => false,
            ])
            ->add('sectionsTyres', CheckboxType::class, [
                'label'    => 'Шины',
                'required' => false,
            ])
            ->add('sectionsDrives', CheckboxType::class, [
                'label'    => 'Диски',
                'required' => false,
            ])
//            ->add('phone', CollectionType::class, [
//                'type'           => ,
//                'allow_add'      => true,
//                'allow_delete'   => true,
//                'prototype_name' => '__prototype__',
//                'by_reference'   => false,
//                'error_bubbling' => false
//            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
