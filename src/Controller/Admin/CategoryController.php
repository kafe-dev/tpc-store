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
use Doctrine\ORM\EntityManagerInterface;
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
     * Override the default
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em);
        $this->serializer = $serializer;
    }
    #[Route("/", name: "index")]
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
    #[Route("/list", name: "list")]
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
	#[Route("/detail/{id}", name: "detail")]
    public function detail(int $id): Response
    {
        // TODO: Implement detail() method.
    }

    /**
     * Action create.
     *
     * This action for creating a new category.
     *
     * @param Request $request
     * @return Response
     */
	#[Route("/create", name: "create")]
    public function create(Request $request): Response
    {
        return $this->render('admin/dashboard/category/create.html.twig');
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
	#[Route("/update/{id}", name: "update")]
    public function update(int $id, Request $request): Response
    {
        // TODO: Implement update() method.
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
	#[Route("/delete/{id}", name: "delete")]
    public function delete(int $id, Request $request): Response
    {
        // TODO: Implement delete() method.
    }
}
