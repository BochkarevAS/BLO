<?php

namespace App\Form\Client;

use App\Entity\Client\Price;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('path', FileType::class, [
                'multiple' => true,
                'label'    => false,
                'attr'     => [
                    'accept'   => 'image/*',
                    'multiple' => 'multiple'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Price::class,
            'csrf_protection' => false,
        ]);
    }
}