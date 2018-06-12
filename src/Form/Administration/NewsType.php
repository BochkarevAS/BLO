<?php

namespace App\Form\Administration;

use App\Entity\Administration\News;
use App\Entity\Client\Company;
use App\Repository\Client\CompanyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'название'
            ])
            ->add('idCompany', EntityType::class, [
                'attr'          => ['class' => 'form-control'],
                'label'         => 'компания',
                'choice_label'  => 'name',
                'data'          => 1,
                'class'         => Company::class,
                'query_builder' => function (CompanyRepository $repository) {
                    return $repository->createCompanyQueryBuilder();
                },

            ])
            ->add('typeNews', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'тип новости'
            ])
            ->add('displayOnMain', ChoiceType::class, [
                'attr'     => ['class' => 'form-control'],
                'label'    => 'показать на главной',
                'choices'  => ['Да' => 1, 'Нет' => 0]
            ])
            ->add('display', ChoiceType::class, [
                'attr'     => ['class' => 'form-control'],
                'label'    => 'показать',
                'choices'  => ['Да' => 1, 'Нет' => 0]
            ])
            ->add('massage', TextareaType::class, [
                'attr'  => ['class' => 'form-control'],
                'label' => 'текст',
            ])
            ->add('img', FileType::class, [
                'label' => 'фото',
                'attr'  => [
                    'class'    => 'form-control',
                    'accept'   => 'image/*',
                    'multiple' => 'multiple'
                ]
            ])
            ->add('url', TextType::class, [
                'attr'     => ['class' => 'form-control'],
                'label'    => 'url',
                'required' => false
            ])
            ->add('title', TextType::class, [
                'attr'     => ['class' => 'form-control'],
                'label'    => 'title',
                'required' => false
            ])
            ->add('keywords', TextType::class, [
                'attr'     => ['class' => 'form-control'],
                'label'    => 'keywords',
                'required' => false
            ])
            ->add('description', TextType::class, [
                'attr'     => ['class' => 'form-control'],
                'label'    => 'description',
                'required' => false
            ])
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