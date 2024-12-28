<?php
/**
 * @project tpc-store
 * @author NTDzVEKNY
 * @email ntdgdeptrai@gmail.com
 * @date 27-Dec-24
 */

namespace App\Form\Type;


use App\Form\Transformer\StringToArrayTransformer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriesType extends AbstractType {
	private StringToArrayTransformer $stringToArrayTransformer;

	public function __construct()
	{
		$this->stringToArrayTransformer = new StringToArrayTransformer();
	}
	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data' => NULL,
		]);
	}

	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
            ->add('name', TextType::class, [
				'required' => true,
				'label' => 'Tên danh mục',
                'attr' => [
                    'placeholder' => 'Điền tên danh mục',
					'class' => 'form-control mb-3',
                ],
			])
			->add('slug', TextType::class, [
				'required' => true,
                'label' => 'Slug',
                'attr' => [
                    'placeholder' => 'Điền slug',
					'class' => 'form-control mb-3',
                ],
			])
            ->add('parent_category', ChoiceType::class, [
				'required' => true,
                'label' => 'Thư mục cha',
				'choices' => $this->getChoice($options['data']),
				'attr' => [
					'class' => 'form-control mb-3',
				],
            ])
			->add('image', FileType::class, [
				'label' => 'Ảnh',
				'mapped' => false,
				'attr' => [
					'class' => 'form-control-file mb-3',
				],
				'required' => false,
				'constraints' => [
					new Image([
						'maxSize' => '2048k',
						'mimeTypesMessage' => 'Vui lòng upload ảnh đúng định dạng',
					])
				],
			])
            ->add('description', TextareaType::class, [
				'label' => 'Mô tả',
                'attr' => [
                    'placeholder' => 'Điền mô tả cho danh mục',
					'class' => 'form-control mb-3',
					'rows' => 7,
                ],
			])

			->add('button', SubmitType::class, [
				'label' => 'Thêm Danh Mục',
				'attr' => [
					'class' => 'btn btn-lg btn-primary btn-block waves-effect waves-light mb-3'
				]
			]);

	}

	private function getChoice($contents): array
	{
		$result = [];
		$result[".None"] = 220;
		foreach ($contents as $content) {
			$result[$content->getName()] = $content->getId();
		}

		return $result;
	}
}