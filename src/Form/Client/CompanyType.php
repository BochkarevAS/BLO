<?php

namespace App\Form\Client;

use App\Entity\Client\Company;
use App\Entity\Client\Section;
use App\Entity\Region\City;
use App\Repository\Region\CityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'    => 'Название компании'
            ])
            ->add('city', TextType::class, [
                'label'    => 'Город',
                'required' => false
            ])
            ->add('syte', TextType::class, [
                'label'    => 'Сайт',
                'required' => false
            ])
            ->add('bank', TextareaType::class, [
                'label'    => 'Банковские реквизиты',
                'required' => false
            ])
            ->add('preview', TextareaType::class, [
                'label'    => 'Краткая информация о компании',
                'required' => false
            ])
            ->add('address', TextareaType::class, [
                'label'    => 'Адрес компании',
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
            ->add('file', VichFileType::class, [
                'required'       => false,
                'allow_delete'   => true,
                'download_label' => false,
                'download_uri'   => false,
                'label'          => 'Логотип'
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