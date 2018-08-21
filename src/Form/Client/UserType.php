<?php

namespace App\Form\Client;

use App\Entity\Auth\User;
use App\Entity\Region\City;
use App\Repository\Region\CityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Email'
            ])
            ->add('first_name', TextType::class, [
                'label' => 'Имя'
            ])
            ->add('phone', TextType::class, [
                'label' => 'Номер'
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
            ->add('avatar', FileType::class, [
                'label'      => 'Аватар',
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
            'data_class'      => User::class,
            'csrf_protection' => false,
        ]);
    }
}