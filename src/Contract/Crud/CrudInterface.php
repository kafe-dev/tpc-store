<?php

declare(strict_types=1);

namespace App\Contract\Crud;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CrudInterface.
 *
 * This interface defined all the common methods for CRUD tasks.
 */
interface CrudInterface
{
    /**
     * Returns data as json response.
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse;

    /**
     * Render the detail page.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function detail(int $id): Response;

    /**
     * Render the create page.
     * And perform the creation action.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function create(Request $request): Response;

    /**
     * Render the update page.
     * And perform the update action.
     *
     * @param  int  $id
     * @param  Request  $request
     *
     * @return Response
     */
    public function update(int $id, Request $request): Response;

    /**
     * Perform the delete action.
     *
     * @param  int  $id
     * @param  Request  $request
     *
     * @return Response
     */
    public function delete(int $id, Request $request): Response;

}
