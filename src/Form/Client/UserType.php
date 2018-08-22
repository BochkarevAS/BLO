<?php

namespace App\Form\Client;

use App\Entity\Auth\User;
use App\Entity\Region\City;
use App\Entity\Region\Region;
use App\Repository\Region\CityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
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
            ->add('region', EntityType::class, [
                'class'         => Region::class,
                'label'         => 'Регион',
                'choice_label'  => 'name',
                'mapped'        => false,
                'required'      => false
            ])
            ->add('avatar', FileType::class, [
                'label'      => 'Аватар',
                'data_class' => null,
                'attr'       => [
                    'accept' => 'image/*',
                ]
            ])
        ;

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();

                /* @var $city City */
                $city = $data->getCity();
                $form = $event->getForm();

                if ($city) {
                    $region = $city->getRegion();
                    $this->formCity($form, $region);
                    $form->get('region')->setData($region);
                } else {
                    $this->formCity($form, null);
                }
            }
        );

        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->formCity($form->getParent(), $form->getData());
            }
        );
    }

    private function formCity(FormInterface $form, ?Region $region = null)
    {
        $form->add('city', EntityType::class, [
            'class'           => City::class,
            'label'           => 'Город',
            'required'        => false,
            'auto_initialize' => false,
            'choices'         => $region ? $region->getCitys() : [],
            'query_builder' => function (CityRepository $repository) {
                return $repository->orderBy();
            }
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => User::class,
            'csrf_protection' => false,
        ]);
    }
}