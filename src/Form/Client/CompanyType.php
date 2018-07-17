<?php

namespace App\Form\Client;

use App\Entity\Client\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
