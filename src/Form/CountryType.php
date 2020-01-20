<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\Department;
use App\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CountryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('region', EntityType::class, [
                'placeholder' => '',
                'class'       => Region::class,
                'mapped'      => false,
                'required'    => false
            ])
        ;

        /**
         * Предварительное заполнение формы.
         */
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();

                /** @var City $city */
                $city = $data->getCity();

                if ($city) {
                    $department = $city->getDepartment();
                    $region     = $department->getRegion();

                    $this->formDepartment($form, $region);
                    $this->formCity($form, $department);

                    $form->get('region')->setData($region);
                    $form->get('department')->setData($department);
                } else {
                    $this->formDepartment($form, null);
                    $this->formCity($form, null);
                }
            }
        );

        /**
         * Получить отправленные данные. Событие сработает после нажатия кнопки submit.
         * Прикрепляет событие только к полю region, а не ко всей форме.
         * Поэтому, когда форма отправляется, Symfony будет вызывать эту функцию,
         * но объект $event будет иметь только информацию о поле region, а не всю форму.
         */
        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                /**
                 * Это дает фактический объект Form для этого одного поля region.
                 */
                $form = $event->getForm();

                /**
                 * Первый аргумент - это $form->getParent() - сама форма CountryType.
                 * Второй аргумент - это само значение поля region (выбранные данные), которое будет $form->getData() или $event->getData().
                 */
                $this->formDepartment($form->getParent(), $form->getData());
            }
        );
    }

    private function formDepartment(FormInterface $form, ?Region $region)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'department',
            EntityType::class,
            null,
            [
                'placeholder'     => '',
                'class'           => Department::class,
                'mapped'          => false,
                'required'        => false,
                'auto_initialize' => false,
                'choices'         => $region ? $region->getDepartments() : []
            ]
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->formCity($form->getParent(), $form->getData());
            }
        );

        $form->add($builder->getForm());
    }

    private function formCity(FormInterface $form, ?Department $department)
    {
        $form->add('city', EntityType::class, [
            'placeholder' => '',
            'class'       => City::class,
            'choices'     => $department ? $department->getCitys() : []
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Country::class,
        ]);
    }
}