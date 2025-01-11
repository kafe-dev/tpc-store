<?php
declare(strict_types=1);
/**
 * @project tpc-store
 * @author  Tra Pham
 * @email   trapham24065@gmail.com
 * @date    12/26/2024
 * @time    9:13 PM
 **/


namespace App\Controller\Admin;
use App\Entity\ProductTag;
use App\Form\Type\ProductTagType;
use App\Repository\ProductRepository;
use App\Repository\ProductTagRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product-tag')]
class ProductTagController extends AbstractController{
	private ProductRepository $productRepository;
	private ProductTagRepository $productTagRepository;
	private TagRepository $tagRepository;
	private EntityManagerInterface $entityManager;

	public function __construct(
		ProductRepository $productRepository,
		ProductTagRepository $productTagRepository,
		TagRepository $tagRepository,
		EntityManagerInterface $entityManager
	) {
		$this->productRepository = $productRepository;
		$this->productTagRepository = $productTagRepository;
		$this->tagRepository = $tagRepository;
		$this->entityManager = $entityManager;
	}
	/**
	 * Get product tags as JSON.
	 */
	#[Route('/api', name: 'product_tag_api', methods: ['GET'])]
	public function api(): JsonResponse
	{
		$productTags = $this->productTagRepository->findAll();

		$groupedProductTags = [];
		foreach ($productTags as $productTag) {
			$productName = $productTag->getProduct()->getName();
			$groupedProductTags[$productName][] = [
				'tag' => $productTag->getTag()->getName(),
				'productId' => $productTag->getProduct()->getId(),
			];
		}
		return $this->json($groupedProductTags);
	}
	/**
	 * Display the list of products and tags.
	 */
	#[Route('/', name: 'product_tag_index', methods: ['GET'])]
	public function index(): Response
	{
		$pageTitle = 'Danh sách sản phẩm và tag';
		return $this->render('admin/product-tag/index.html.twig',[
			'pageTitle' => $pageTitle,
		]);
	}

	/**
	 * Display product details and its tags in HTML format.
	 */
	#[Route('/{id}/show', name: 'product_tag_show', methods: ['GET'])]
	public function show(int $id): Response
	{
		$pageTitle = 'Chi tiết sản phẩm và tag';

		return $this->render('admin/product-tag/show.html.twig', [
			'id' => $id,
			'pageTitle' => $pageTitle
		]);
	}

	/**
	 * Get product details and its tags as JSON (API).
	 */
	#[Route('/api/{id}/show', name: 'product_tag_api_show', methods: ['GET','POST'])]
	public function apiShow(int $id): JsonResponse
	{
		$product = $this->productRepository->find($id);
		$productTags = $this->productTagRepository->findBy(['product' => $product]);

		$tags = [];
		foreach ($productTags as $productTag) {
			$tags[] = [
				'tag_id' => $productTag->getTag()->getId(),
				'tag_name' => $productTag->getTag()->getName(),
				'tag_description' => $productTag->getTag()->getDescription(),
				'tag_slug' => $productTag->getTag()->getSlug(),
			];
		}
		$product = [
			'name' => $product->getName(),
			'description' => $product->getDescription(),
			'short_description' => $product->getShortDescription(),
			'slug' => $product->getSlug(),
			'original_price' => $product->getOriginalPrice(),
			'status' => $product->getStatus(),
			];
		return $this->json([
			'product' => $product,
			'tags' => $tags,
		]);
	}

	/**
	 * Add a new tag to a product.
	 */
	#[Route('/new', name: 'product_tag_new', methods: ['GET', 'POST'])]
	public function new(Request $request): Response
	{
		$pageTitle = 'Thêm tag vào sản phẩm';
		$productTag = new ProductTag();
		$form = $this->createForm(ProductTagType::class, $productTag);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid())
		{
			$existingProductTag = $this->productTagRepository->findOneBy([
				'product' => $productTag->getProduct(),
				'tag' => $productTag->getTag(),
			]);

			if ($existingProductTag)
			{
				$this->addFlash('error', 'Sản phẩm đã có tag.');
				return $this->redirectToRoute('product_tag_new');
			} else
			{
				$this->entityManager->persist($productTag);
				$this->entityManager->flush();

				$this->addFlash('success', 'Thêm tag trong sản phẩm thành công.');
				return $this->redirectToRoute('product_tag_new');
			}
		}
		return $this->render('admin/product-tag/new.html.twig', [
			'pageTitle' => $pageTitle,
			'form' => $form->createView(),
		]);
	}
	/**
	 * Delete a specific tag from a product.
	 */
	#[Route('/{tag_id}/{product_id}/delete-tag', name: 'product_tag_delete_tag', methods: ['POST'])]
	public function deleteTag(int $tag_id, int $product_id): Response
	{
		try
		{
			$tag = $this->tagRepository->find($tag_id);

			$productTags = $this->productTagRepository->findBy([
				'tag' => $tag,
				'product' => $product_id
			]);
			foreach ($productTags as $productTag)
			{
				$this->entityManager->remove($productTag);
			}
			$this->entityManager->flush();
			$this->addFlash('success', 'Xóa thành công.');
		}
		catch (\Exception $e) {
			$this->addFlash('error', 'Đã xảy ra lỗi khi xóa tag: ' . $e->getMessage());
		}
		return $this->redirectToRoute('product_tag_show', ['id' => $product_id], Response::HTTP_SEE_OTHER);
	}
	/**
	 * Delete all tags of a product.
	 */
	#[Route('/{id}/tags/delete-all', name: 'product_tags_delete_all', methods: ['POST'])]
	public function deleteAllTags(int $id): Response
	{
		$product = $this->productRepository->find($id);
		$productTags = $this->productTagRepository->findBy(['product' => $product]);
		foreach ($productTags as $productTag) {
			$this->entityManager->remove($productTag);
		}
		$this->entityManager->flush();
		return $this->redirectToRoute('product_tag_index',[], Response::HTTP_SEE_OTHER);
	}

}