<?php

declare(strict_types=1);

namespace App\Form\Tyre;

use App\DBAL\Types\AvailabilityType;
use App\DBAL\Types\ConditionType;
use App\DBAL\Types\ProtectorTypes;
use App\DBAL\Types\TyreTypes;
use App\Dto\TyreDto;
use App\Entity\Region\City;
use App\Entity\Tyres\Brand;
use App\Entity\Tyres\Model;
use App\Repository\Region\CityRepository;
use App\Repository\Tyre\ModelRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Image;

class TyreCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* Возьму последние 10 лет */
        $date = new \DateTime();
        $year = $date->format('Y');

        $years     = array_combine(range($year, $year - 10, 1), range($year, $year - 10, 1));
        $widths    = array_combine(range(105, 815, 5), range(105, 815, 5));
        $heights   = array_combine(range(25, 110, 5), range(25, 110, 5));
        $quantitys = array_combine(range(1, 10, 1), range(1, 10, 1));
        $diameters = array_combine(range(6, 57, 0.5), range(6, 57, 0.5));
        $wears     = array_combine(range(10, 100, 10), range(10, 100, 10));

        /** Ширина колеса в дюймах */
        $widthsIn = [
            '3.5', '4', '4.5', '5', '5.25', '5.5', '5.75', '6', '6.25', '6.75', '7', '7.25', '7.5', '7.75', '8', '8.25', '8.5',
            '9', '9.5', '9.75', '10', '10.25', '10.5', '11', '11.25', '11.5', '11.75', '12', '12.5', '13', '13.5', '14', '14.25',
            '14.5', '15', '15.5', '15.75', '16', '16.25', '16.5', '16.75', '17', '17.5', '18', '18.5', '19', '19.5', '20', '20.5',
            '20.75', '21', '21.25', '22', '22.5', '23', '23.5', '24', '24.5', '25', '25.75', '26', '26.5', '27.5', '28', '29',
            '29.5', '30', '30.5', '31', '32', '33', '35'
        ];
        $widthsIn = array_combine($widthsIn, $widthsIn);

        /** Высота колеса в дюймах */
        $heightsIn = [
            '12', '12.5', '13.5', '14', '15', '15.5', '16', '16.5', '17', '17.5', '18', '18.5', '19', '20', '20.5', '21',
            '21.5', '22', '23', '23.5', '24', '24.5', '25', '25.5', '26', '26.5', '27', '27.5', '28', '28.5', '29', '29.5',
            '30', '30.5', '31', '31.5', '32', '32.5', '33', '33.5', '34', '34.5', '35', '35.5', '35', '36.5', '37', '37.5',
            '38', '38.5', '39', '39.5', '40', '40.5', '41', '41.5', '42', '42.5', '43', '43.5', '44', '44.5', '45', '45.5',
            '46', '46.5', '47', '47.5', '48', '48.5', '49', '49.5', '50', '50.5', '51', '52.5', '53', '53.5', '54', '54.5',
            '55', '55.5', '56', '57', '57.5', '58', '59', '59.5', '60', '61', '62', '62.5', '63', '64.5', '65', '66', '66.5',
            '67', '67.5', '68', '68.5', '71.5', '72', '73.5', '74', '76', '76.5', '79', '79.5', '80.5', '81.5', '84', '85.5',
            '87.5', '88', '90.5', '91'
        ];
        $heightsIn = array_combine($heightsIn, $heightsIn);

        /** Диаметр колеса в дюймах */
        $diametersIn = [
            '4', '4.5', '5', '5.5', '6', '6.5', '7', '7.5', '8', '8.5', '9', '9.5', '10', '10.5', '11', '11.5', '12', '12.5',
            '13', '13.5', '14', '14.5', '15', '15.5', '16', '16.5', '17', '17.5', '18', '19', '19.5', '20', '20.5', '21', '22',
            '22.5', '23.5', '24', '24.5', '25', '26', '27', '28', '30', '32', '33', '34', '35', '35.5', '38', '40', '42', '45',
            '46', '48', '50', '51', '52', '55', '57'
        ];

        $diametersIn = array_combine($diametersIn, $diametersIn);

        /* Добовляю 5 процентов */
        $wears[5] = 5;

        $builder
            ->add('brand', EntityType::class, [
                'class'         => Brand::class,
                'label'         => 'Производитель',
                'required'      => false,
                'choice_label'  => 'name'
            ])
            ->add('protector', ChoiceType::class, [
                'choices'     => ProtectorTypes::getChoices(),
                'label'       => 'Протектор',
                'required'    => false,
                'placeholder' => 'Все'
            ])
            ->add('type', ChoiceType::class, [
                'choices'     => TyreTypes::getChoices(),
                'label'       => 'Тип шины',
                'required'    => false,
                'placeholder' => 'Все'
            ])
            ->add('city', EntityType::class, [
                'class'         => City::class,
                'label'         => 'Город',
                'choice_label'  => 'name',
                'required'      => false,
                'query_builder' => function (CityRepository $repository) {
                    return $repository->orderBy();
                }
            ])
            ->add('diameter', ChoiceType::class, [
                'choices'  => $diameters,
                'label'    => 'Диаметр',
                'required' => false
            ])
            ->add('height', ChoiceType::class, [
                'choices'  => $heights,
                'label'    => 'Высота',
                'required' => false
            ])
            ->add('width', ChoiceType::class, [
                'choices'  => $widths,
                'label'    => 'Ширина',
                'required' => false
            ])
            ->add('widthIn', ChoiceType::class, [
                'choices'  => $widthsIn,
                'label'    => 'Ширина',
                'required' => false
            ])
            ->add('diameterIn', ChoiceType::class, [
                'choices'  => $diametersIn,
                'label'    => 'Диаметр',
                'required' => false
            ])
            ->add('heightIn', ChoiceType::class, [
                'choices'  => $heightsIn,
                'label'    => 'Высота',
                'required' => false
            ])
            ->add('quantity', ChoiceType::class, [
                'choices'  => $quantitys,
                'label'    => 'Количество',
                'required' => false
            ])
            ->add('year', ChoiceType::class, [
                'choices'  => $years,
                'label'    => 'Год',
                'required' => false
            ])
            ->add('availability', ChoiceType::class, [
                'choices'     => AvailabilityType::getChoices(),
                'label'       => 'Наличие',
                'required'    => false,
                'expanded'    => true,
                'placeholder' => 'Все'
            ])
            ->add('condition', ChoiceType::class, [
                'choices'     => ConditionType::getChoices(),
                'label'       => 'Состояние',
                'required'    => false,
                'expanded'    => true,
                'placeholder' => 'Все'
            ])
            ->add('wear', ChoiceType::class, [
                'choices'     => $wears,
                'label'       => 'Износ',
                'required'    => false,
                'expanded'    => true,
                'placeholder' => 'Все'
            ])
            ->add('textDeclaration', TextareaType::class, [
                'label'    => 'Текст объявления',
                'required' => false
            ])
            ->add('address', TextType::class, [
                'label'    => 'Адрес самовывоза',
                'required' => false
            ])
            ->add('deliveryCity', CheckboxType::class, [
                'label'    => 'По городу',
                'required' => false
            ])
            ->add('deliveryCompany', CheckboxType::class, [
                'label'    => 'До транспортной компании',
                'required' => false
            ])
            ->add('deliveryPost', CheckboxType::class, [
                'label'    => 'Почтой России',
                'required' => false
            ])
            ->add('deliveryPayment', TextareaType::class, [
                'label'    => 'Условия доставки и оплаты',
                'required' => false
            ])
            ->add('price', TextType::class, [
                'label'    => 'Цена',
                'required' => false
            ])
            ->add('images', FileType::class, [
                'label'      => 'Фото',
                'required'   => false,
                'data_class' => null,
                'multiple'   => true,
                'attr'       => [
                    'accept' => 'image/*'
                ],
                'constraints' => [
                    new All([
                        'constraints' => [
                            new Image([
                                'maxSize' => '2M'
                            ])
                        ]
                    ])
                ]
            ])
        ;

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();

                /* @var Brand $brand */
                $brand = $data->brand;
                $form  = $event->getForm();

                if ($brand) {
                    $this->formModel($form, $brand);
                } else {
                    $this->formModel($form, null);
                }
            }
        );

        $builder->get('brand')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->formModel($form->getParent(), $form->getData());
            }
        );
    }

    private function formModel(FormInterface $form, ?Brand $brand = null)
    {
        $form->add('model', EntityType::class, [
            'class'           => Model::class,
            'label'           => 'Модель',
            'required'        => false,
            'auto_initialize' => false,
            'choices'         => $brand ? $brand->getModels() : [],
            'query_builder'   => function (ModelRepository $repository) {
                return $repository->orderBy();
            }
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => TyreDto::class,
            'csrf_protection' => false,
        ]);
    }
}