<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Supplier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;

class SupplierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Tên nhà cung cấp',
            ])
            ->add('address', TextType::class, [
                'mapped' => false,
                'label' => 'Địa chỉ',
            ])
            ->add('description', TextareaType::class, [
                'mapped' => false,
                'label' => 'Thông tin chung',
            ])
            ->add('phone', TextType::class, [
                'mapped' => false,
                'label' => 'Liên hệ',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\+?[0-9]{10,15}$/', // Example phone number pattern (international format)
                        'message' => 'Số điện thoại không hợp lệ.',
                    ]),
                ],
            ])
            ->add('email', TextType::class, [
                'mapped' => false,
                'label' => 'Email',
                'constraints' => [
                    new Email([
                        'message' => 'Email không hợp lệ.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Supplier::class,
        ]);
    }
}
