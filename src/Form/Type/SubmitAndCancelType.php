<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubmitAndCancelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('submit', SubmitType::class, [
                'label' => 'Lưu',
                'row_attr' => [
                    'class' => 'form-group row d-flex justify-content-end mr-4',
                ],
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
            ->add('button', ButtonType::class, [
                'label' => 'Hủy',
                'row_attr' => [
                    'class' => 'form-group row d-flex justify-content-end',
                ],
                'attr' => [
                    'class' => 'btn btn-secondary',
                    'onclick' => sprintf("window.location.href='%s';", $options['cancel_url']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('cancel_url', '#');
    }
}
