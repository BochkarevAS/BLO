<?php

namespace App\Form\Client;

use App\Entity\Client\Company;
use App\Entity\Client\Section;
use App\Entity\Region\City;
use App\Repository\Region\CityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('bank', CKEditorType::class, [
                'label' => 'Банковские реквизиты',
                'config' => [
                    'uiColor' => '#00BFFF'
                ]
            ])
            ->add('preview', CKEditorType::class, [
                'label' => 'Краткая информация о компании',
                'config' => [
                    'uiColor' => '#00BFFF'
                ]
            ])
            ->add('address', CKEditorType::class, [
                'label' => 'Адрес компании',
                'config' => [
                    'uiColor' => '#00BFFF'
                ]
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
            ->add('sections', EntityType::class, [
                'class'        => Section::class,
                'multiple'     => true,
                'expanded'     => true,
                'label'        => 'Активные разделы с прайсами',
                'choice_label' => 'name'
            ])
            ->add('phones', CollectionType::class, [
                'label'        => false,
                'entry_type'   => PhoneEmbeddedForm::class,
                'allow_delete' => true,
                'allow_add'    => true,
                'by_reference' => false
            ])
            ->add('emails', CollectionType::class, [
                'label'        => false,
                'entry_type'   => EmailEmbeddedForm::class,
                'allow_delete' => true,
                'allow_add'    => true,
                'by_reference' => false
            ])
            ->add('logotype', FileType::class, [
                'label'      => 'Логотип',
                'data_class' => null,
                'attr'       => [
                    'accept' => 'image/*',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Company::class,
            'csrf_protection' => false
        ]);
    }
}
