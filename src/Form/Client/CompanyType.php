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
            ->add('bank', TextareaType::class, [
                'label' => 'Банковские реквизиты'
            ])
            ->add('preview', TextareaType::class, [
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
            ->add('phones', CollectionType::class, [
                'label'        => 'Телефон',
                'entry_type'   => PhoneEmbeddedForm::class,
                'allow_delete' => true,
                'allow_add'    => true,
                'by_reference' => false
            ])
            ->add('emails', CollectionType::class, [
                'label'        => 'Email',
                'entry_type'   => EmailEmbeddedForm::class,
                'allow_delete' => true,
                'allow_add'    => true,
                'by_reference' => false
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class
        ]);
    }
}
