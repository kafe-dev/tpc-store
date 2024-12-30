<?php

/**
 * @project tpc-store
 * @author NTDzVEKNY
 * @email ntdgdeptrai@gmail.com
 * @date 26-Dec-24
 * @time 9:30 PM
 */

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Contract\Crud\CrudInterface;
use App\Controller\BaseController;
use App\Entity\Category as CategoryEntity;
use App\Form\Type\CategoriesType;
use App\Repository\CategoryRepository;
use App\Utils\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class CategoryController.
 *
 * This is a controller used to manage the categories.
 */
#[Route("/admin/category", name: "admin_category_")]
class Category extends BaseController implements CrudInterface
{
    /**
     * @var FileUploader $fileUploader File Uploader
     */
    private FileUploader $fileUploader;

    /**
     * Category Repository
     *
     * @var CategoryRepository $categoryRepository
     */
    private CategoryRepository $categoryRepository;

    /**
     * Override the default
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     * @param FileUploader $fileUploader
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer, FileUploader $fileUploader)
    {
        parent::__construct($em, $serializer);

        $this->fileUploader = $fileUploader;
        $this->categoryRepository = $this->em->getRepository(CategoryEntity::class);
    }

    #[Route("/", name: "index", methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/category/index.html.twig');
    }

    /**
     * Action list.
     *
     * This action for getting all categories.
     *
     * @return JsonResponse
     */
    #[Route("/list", name: "list", methods: ['GET'])]
    public function list(): JsonResponse
    {
        $categories = $this->categoryRepository->findAll();
        $data = [];
        $json = $this->serializer->serialize($categories, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getName();
            },
        ]);
        $categories = json_decode($json, true);

        if (! empty($categories)) {
            foreach ($categories as $category) {
                $categoryEntity = $this->categoryRepository->find($category['id']);
                $category['childrens'] = $this->categoryRepository->countChildren($categoryEntity);
                $category['actions'] = [
                    'detail' => $this->generateUrl('admin_category_detail', ['id' => $categoryEntity->getId()]),
                    'update' => $this->generateUrl('admin_category_update', ['id' => $categoryEntity->getId()]),
                    'delete' => $this->generateUrl('admin_category_delete', ['id' => $categoryEntity->getId()]),
                ];
                $category['parent_name'] = is_null($categoryEntity->getParent()) ? '-' : $categoryEntity->getParent()->getName();
                $data[] = $category;
            }
        }
        return new JsonResponse($data);
    }

    /**
     * Action detail.
     *
     * This action for rending the detail page.
     *
     * @param int $id
     * @return Response
     */
    #[Route("/detail/{id}", name: "detail", methods: ['GET'])]
    public function detail(int $id): Response
    {
        $task = $this->categoryRepository->find($id);

        return $this->render('admin/category/detail.html.twig', [
            'page_title' => 'Chi Tiết Danh Mục',
            'category' => $task,
        ]);
    }

    /**
     * Action create.
     *
     * This action for creating a new category.
     *
     * @param Request $request
     * @return Response
     */
    #[Route("/create", name: "create", methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $category = new CategoryEntity();

        $form = $this->getForm($category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (! $this->categoryRepository->isSlugUnique($form->get('slug')->getData())) {
                return $this->redirectToRoute('admin_category_create');
            }

            $this->persistData($category, $form, true);
            $this->em->flush();

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/category/create.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * Action update.
     *
     * This action for updating a category.
     *
     * @param int $id
     * @param Request $request
     * @return Response
     */
    #[Route("/update/{id}", name: "update", methods: ['GET', 'POST'])]
    public function update(int $id, Request $request): Response
    {
        $category = $this->categoryRepository->find($id);

        $form = $this->getForm($category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (! $this->categoryRepository->isSlugUnique($form->get('slug')->getData()) && $form->get('slug')->getData() != $category->getSlug()) {
                return $this->redirectToRoute('admin_category_update', ['id' => $id]);
            }

            $this->persistData($category, $form);

            try {
                $this->em->flush();

                $this->addFlash('success', 'Cập nhật thành công!');

                return $this->redirectToRoute('admin_category_index');
            } catch (Exception $e) {
                $this->addFlash('error', 'Cập nhật thất bại!');
                $this->addFlash('error', $e->getMessage());

                return $this->redirectToRoute('admin_category_index');
            }
        }

        return $this->render('admin/category/update.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * Action delete.
     *
     * This action for deleting a category.
     *
     * @param int $id
     * @param Request $request
     * @return Response
     */
    #[Route("/delete/{id}", name: "delete", methods: ['POST'])]
    public function delete(int $id, Request $request): Response
    {
        $task = $this->categoryRepository->find($id);

        if ($task) {
            $this->em->remove($task);
            $this->em->flush();
            $this->addFlash('success', 'Xóa thành công!');
        } else {
            $this->addFlash('error', 'Xóa thất bại!');
        }

        return $this->redirectToRoute('admin_category_index');
    }

    /**
     * Action Bulk Delete
     *
     * This action for delete list categories
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    #[Route("/bulkDelete", name: "bulk_delete", methods: ['POST'])]
    public function bulkDelete(Request $request): Response
    {
        $ids = $request->request->all('ids');

        if (empty($ids)) {
            throw new Exception('No IDs provided for deletion.');
        }

        foreach ($ids as $id) {
            $entity = $this->categoryRepository->find($id);
            $this->em->remove($entity);
        }

        $this->em->flush();
        $this->addFlash('success', 'Xóa thành công!');

        return $this->redirectToRoute('admin_category_index');
    }

    /**
     * Persist Data before flushing.
     *
     * @param CategoryEntity $category
     * @param $form
     * @param bool $needPersist
     * @return void
     */
    private function persistData(CategoryEntity $category, $form, bool $needPersist = false): void
    {
        $category->setName($form->get('name')->getData());
        $category->setSlug($form->get('slug')->getData());
        $category->setDescription($form->get('description')->getData());
        $category->setParent($form->get('parent')->getData());
        $category->setStatus($form->get('status')->getData());

        /** @var UploadedFile $imageFile */
        $imageFile = $form->get('image')->getData();

        if ($imageFile) {
            $imageFileName = $this->fileUploader->upload($imageFile);
            $category->setImage($imageFileName);
        }

        if ($needPersist === true) {
            $this->em->persist($category);
        }
    }

    /**
     * Get Form Builder.
     *
     * @param CategoryEntity $category
     * @return FormInterface
     */
    private function getForm(CategoryEntity $category): FormInterface
    {
        return $this->createForm(CategoriesType::class, $category, [
            'data' => $this->categoryRepository->findAll(),
            'cancel_url' => $this->generateUrl('admin_category_index'),
        ]);
    }
}
