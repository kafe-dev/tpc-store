<?php

declare(strict_types=1);

/**
 * @project tpc-store
 * @author Tanh
 * @email tuananh182004@gmail.com
 * @date 12/26/2024
 * @time 9:38 PM
 */

namespace App\Controller\Admin;

use App\Contract\Crud\CrudInterface;
use App\Controller\BaseController;
use App\Entity\SaleEvent;
use App\Form\Type\SaleEventType;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Flasher\Prime\FlasherInterface;

/**
 * Class SaleEventController.
 *
 * This controller used to manage the sale event.
 */

#[Route(path: '/admin/sale_event', name: 'admin_sale-event_')]
class SaleEventController extends BaseController implements CrudInterface
{
    /**
     * Return list of settings in json format.
     *
     * @return Response
     */
    #[Route('/getList', name: 'get_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $sale_event = $this->em->getRepository(SaleEvent::class)->findAll();

        return $this->json($sale_event);
    }


    /**
     * Return list of settings in json format.
     *
     * @return Response
     */
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $discountTypes = SaleEvent::DISCOUNT_TYPES;

        $data = [
            'page_title' => 'Quản lý sự kiện sale',
            'discount_types' => json_encode($discountTypes),
        ];
        return $this->render('admin/sale_event/index.html.twig', $data);
    }

    /**
     * Render detail of sale event.
     *
     * @inheritDoc
     */
    #[Route('/detail/{id}', name: 'detail', methods: ['GET'])]
    public function detail(int $id): Response
    {
        $task = $this->em->getRepository(SaleEvent::class)->find($id);

        return $this->render('admin/sale_event/detail.html.twig', [
            'page_title' => 'Chi tiết sự kiện sale',
            'sale_event' => $task,
        ]);
    }


    /**
     * Render form to create new sale event
     * and perform create action.
     *
     * @inheritDoc
     */
    #[Route(path: '/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $sale_event = new SaleEvent();
        $form = $this->createForm(SaleEventType::class, $sale_event, [
            'action' => $this->generateUrl('admin_sale-event_create'),
            'attr' => [
                'class' => 'form-horizontal',
            ],
            'cancel_url' => $this->generateUrl('admin_sale-event_index'),
        ]);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();

                $this->em->persist($data);
                $this->em->flush();

                flash()->success('Tạo sự kiện sale thành công!');
                return $this->redirectToRoute('admin_sale-event_index');
            } else {
                flash()->error('Tạo mới sự kiện sale thất bại!');
            }
        }
        return $this->render('admin/sale_event/create.html.twig', [
            'page_title' => 'Tạo Sự Kiện Sale Mới',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Render form to update sale event
     * and perform update action.
     *
     * @inheritDoc
     */
    #[Route(path: '/update/{id}', name: 'update', methods: ['GET', 'POST'])]
    public function update(int $id, Request $request): Response
    {
        $task = $this->em->getRepository(SaleEvent::class)->find($id);

        $form = $this->createForm(SaleEventType::class, $task, [
            'action' => $this->generateUrl('admin_sale-event_update', ['id' => $id]),
            'attr' => [
                'class' => 'form-horizontal',
            ],
            'cancel_url' => $this->generateUrl('admin_sale-event_index'),
        ]);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                try {
                    $this->em->flush();

                    flash()->success('Cập nhật sự kiện Sale thành công!');
                    return $this->redirectToRoute('admin_sale-event_index');
                } catch (Exception $e) {
                    flash()->error('Cập nhật sự kiện Sale thất bại!');

                    flash()->error($e->getMessage());
                }
            } else {
                flash()->error('Cập nhật sự kiện Sale thất bại!');

                foreach ($form->getErrors(true) as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
            }
        }

        return $this->render('admin/sale_event/update.html.twig', [
            'page_title' => 'Cập nhật sự kiện Sale',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Render form to delete sale event
     * and perform delete action.
     *
     * @inheritDoc
     */
    #[Route(path: '/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(int $id, Request $request): Response
    {
        $task = $this->em->getRepository(SaleEvent::class)->find($id);

        if ($task) {
            $this->em->remove($task);
            $this->em->flush();

            flash()->success('Xóa sự kiện Sale thành công!');
        } else {
            flash()->error('Xóa sự kiện Sale thất bại!');
        }

        return $this->redirectToRoute('admin_sale-event_index');
    }

}
