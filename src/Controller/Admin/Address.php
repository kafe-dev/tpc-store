<?php
/**
 * @project tpc-store
 * @author NTDzVEKNY
 * @email ntdgdeptrai@gmail.com
 * @date 1/6/2025
 * @time 2:12 PM
 */

namespace App\Controller\Admin;

use App\Contract\Crud\CrudInterface;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/admin/address", name: "admin_address_")]
class Address extends BaseController implements CrudInterface
{
    /**
     *  This is default action in Controller
     *
     * @Response
     */
    #[Route('/', name: "index" , methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/address/index.html.twig');
    }

    /**
     * @inheritDoc
     */
    public function list(): JsonResponse
    {
        // TODO: Implement list() method.
    }

    /**
     * @inheritDoc
     */
    public function detail(int $id): Response
    {
        // TODO: Implement detail() method.
    }

    /**
     * @inheritDoc
     */
    public function create(Request $request): Response
    {
        // TODO: Implement create() method.
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, Request $request): Response
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id, Request $request): Response
    {
        // TODO: Implement delete() method.
    }
}