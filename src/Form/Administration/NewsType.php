<?php

namespace App\Form\Administration;

use App\Entity\Administration\News;
use App\Entity\Client\Company;
use App\Repository\Client\CompanyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('company', EntityType::class, [
                'class'         => Company::class,
                'query_builder' => function (CompanyRepository $repository) {
                    return $repository->createCompanyQueryBuilder();
                }
            ])
            ->add('typeNews')
            ->add('displayOnMain', ChoiceType::class, [
                'choices'  => [
                    'Да'   => 1,
                    'Нет'  => 0,
                ]
            ])
            ->add('display', ChoiceType::class, [
                'choices'  => [
                    'Да'   => 1,
                    'Нет'  => 0,
                ]
            ])
            ->add('massage', TextareaType::class)
            ->add('img')
            ->add('url')
            ->add('title')
            ->add('keywords')
            ->add('description')
            ->add('uid')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => News::class,
            'csrf_protection' => false,
        ]);
    }
}