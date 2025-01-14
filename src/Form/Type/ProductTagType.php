<?php
declare(strict_types=1);
/**
 * @project tpc-store
 * @author  Tra Pham
 * @email   trapham24065@gmail.com
 * @date    12/26/2024
 * @time    10:19 PM
 **/

namespace App\Form\Type;
use App\Entity\Product;
use App\Entity\ProductTag;
use App\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class ProductTagType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('product', EntityType::class, [
				'class' => Product::class,
				'choice_label' => 'name',
				'placeholder' => 'Chọn sản phẩm',
				'required' => FALSE,
				'label' => 'Sản phẩm :',
				'attr' => [
					'class' => 'form-select',
				],
			])
			->add('tag', EntityType::class, [
				'class' => Tag::class,
				'choice_label' => 'name',
				'placeholder' => 'Chọn Tag',
				'required' => FALSE,
				'label' => 'Tag :',
				'attr' => [
					'class' => 'form-select',
				],
			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => 	ProductTag::class,
		]);
	}
}