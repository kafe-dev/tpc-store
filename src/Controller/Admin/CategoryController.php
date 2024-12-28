<?php

/**
 * @project tpc-store
 * @author NTDzVEKNY
 * @email ntdgdeptrai@gmail.com
 * @date 26-Dec-24
 * @time 9:30 PM
 */

namespace App\Controller\Admin;

use App\Contract\Crud\CrudInterface;
use App\Controller\BaseController;
use App\Entity\Category;
use App\Form\Type\CategoriesType;
use App\Utils\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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
class CategoryController extends BaseController implements CrudInterface
{
    /**
     * @var SerializerInterface SerializerInterface
     */
    protected SerializerInterface $serializer;

    /**
     * @var FileUploader UploaderInterface
     */
    private FileUploader $fileUploader;

    /**
     * Override the default
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     * @param FileUploader $fileUploader
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer, FileUploader $fileUploader)
    {
        parent::__construct($em);
        $this->serializer = $serializer;
        $this->fileUploader = $fileUploader;
    }
    #[Route("/", name: "index", methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/dashboard/category/index.html.twig');
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
        $categories = $this->em->getRepository(Category::class)->findAll();
        $data = [];

        if (!empty($categories)) {
            foreach ($categories as $key => $category) {
                $data[] = [
                    'slug' => $category->getSlug(),
                    'name' => $category->getName(),
                    'parent' => is_null($category->getParent()) ? '-' : $category->getParent()->getName(),
                    'status' => $category->getStatus(),
                    'image' => $category->getImage(),
                    'description' => $category->getDescription(),
                    'actions' => [
                        'detail' => $this->generateUrl('admin_category_detail', ['id' => $category->getId()]),
                        'update' => $this->generateUrl('admin_category_update', ['id' => $category->getId()]),
                        'delete' => $this->generateUrl('admin_category_delete', ['id' => $category->getId()]),
                    ]
                ];
            }
        }

        return new JsonResponse(['data' => $data]);
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
        $task = $this->em->getRepository(Category::class)->find($id);

        return $this->render('admin/dashboard/category/detail.html.twig', [
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
    #[Route("/create", name: "create", methods: ['GET','POST'])]
    public function create(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoriesType::class, $category, [
            'data' => $this->em->getRepository(Category::class)->findAll(),
            'cancel_url' => $this->generateUrl('admin_category_index'),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->em->getRepository(Category::class)->isSlugUnique($form->get('slug')->getData())) {
                return $this->redirectToRoute('admin_category_create');
            }
            // need to update this
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

            $this->em->persist($category);
            $this->em->flush();

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/dashboard/category/create.html.twig', [
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
        $category = $this->em->getRepository(Category::class)->find($id);
        ;


        $form = $this->createForm(CategoriesType::class, $category, [
            'data' => $this->em->getRepository(Category::class)->findAll(),
            'cancel_url' => $this->generateUrl('admin_category_index'),

        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->em->getRepository(Category::class)->isSlugUnique($form->get('slug')->getData()) && $form->get('slug')->getData() != $category->getSlug()) {
                return $this->redirectToRoute('admin_category_update', ['id' => $id]);
            }
            // need to update this
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

        return $this->render('admin/dashboard/category/update.html.twig', [
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
        $task = $this->em->getRepository(Category::class)->find($id);

        if ($task) {
            $this->em->remove($task);
            $this->em->flush();

            $this->addFlash('success', 'Xóa thành công!');
        } else {
            $this->addFlash('error', 'Xóa thất bại!');
        }

        return $this->redirectToRoute('admin_category_index');
    }
}
