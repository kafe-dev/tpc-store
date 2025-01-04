<?php

namespace App\Form\Type;

use App\Entity\SaleEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaleEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Tên Sự Kiện Sale:',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Điền Tên Sự Kiện Sale',
                ],
            ])
            ->add('discount_amount', TextType::class, [
                'required' => true,
                'label' => 'Lượng Giảm Giá:',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Điền lượng giảm giá',
                ],
            ])
            ->add('discount_type', ChoiceType::class, [
                'choices'  => [
                    SaleEvent::DISCOUNT_TYPES[SaleEvent::DISCOUNT_TYPE_PERCENTAGE] => SaleEvent::DISCOUNT_TYPE_PERCENTAGE,
                    SaleEvent::DISCOUNT_TYPES[SaleEvent::DISCOUNT_TYPE_FLAT]    => SaleEvent::DISCOUNT_TYPE_FLAT,
                ],
                'required' => true,
                'label'    => 'Chọn kiểu giảm giá:',
                'attr'     => [
                    'class' => 'form-select mb-3',
                    'placeholder' => 'Chọn kiểu giảm giá:',
                ],
            ])
            ->add('start_at', DateTimeType::class, [
                'required' => true,
                'label' => 'Bắt Đầu Vào:',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('end_at', DateTimeType::class, [
                'required' => true,
                'label' => 'Kết Thúc Vào:',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('submit', SubmitAndCancelType::class, [
                'mapped' => false,
                'label' => false,
                'attr' => [
                    'class' => 'form-group row d-flex justify-content-end',
                ],
                'cancel_url' => $options['cancel_url'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->resolve([
            'data_class' => SaleEvent::class
        ]);

        $resolver->setDefault('cancel_url', null);
    }
}
