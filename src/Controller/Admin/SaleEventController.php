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
use App\Entity\ProductVariant;
use App\Entity\ProductVariantSaleEvent;
use App\Entity\SaleEvent;
use App\Entity\SaleEventMeta;
use App\Form\Type\SaleEventType;
use App\Repository\ProductVariantRepository;
use App\Repository\ProductVariantSaleEventRepository;
use App\Repository\SaleEventMetaRepository;
use App\Repository\SaleEventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Flasher\Prime\FlasherInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class SaleEventController.
 *
 * This controller used to manage the sale event.
 */

#[Route(path: '/admin/sale_event', name: 'admin_sale_event_')]
class SaleEventController extends BaseController implements CrudInterface
{
    /**
     * Sale Event Repository
     *
     * @var SaleEventRepository $saleEventRepository
     */
    private SaleEventRepository $saleEventRepository;
    /**
     * Product Variant Sale Event Repository
     *
     * @var ProductVariantSaleEventRepository $productVariantSaleEventRepository
     */
    private ProductVariantSaleEventRepository $productVariantSaleEventRepository;
    /**
     * Sale Event Meta Repository
     *
     * @var SaleEventRepository $saleEventMetaRepository
     */
    private SaleEventMetaRepository $saleEventMetaRepository;
    /**
     * Product Variant Repository
     *
     * @var ProductVariantRepository $productVariantRepository
     */
    private ProductVariantRepository $productVariantRepository;
    private SerializerInterface $serializer;
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer);

        $this->saleEventRepository = $em->getRepository(SaleEvent::class);
        $this->productVariantSaleEventRepository = $em->getRepository(ProductVariantSaleEvent::class);
        $this->saleEventMetaRepository = $em->getRepository(SaleEventMeta::class);
        $this->productVariantRepository = $em->getRepository(ProductVariant::class);
        $this->serializer = $serializer;
    }


    /**
     * Return list of settings in json format.
     *
     * @return Response
     */
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $sale_event = $this->em->getRepository(SaleEvent::class)->findAll();

        $data = [];
        foreach ($sale_event as $event) {
            $data[] = [ 'id' => $event->getId(),
                        'name' => $event->getName(),
                        'discountAmount' => $event->getDiscountAmount(),
                        'discountType' => $event->getDiscountType(),
                        'startAt' => $event->getStartAt(),
                        'endAt' => $event->getEndAt(),
                        'createdAt' => $event->getCreatedAt(),
                        'updatedAt' => $event->getUpdatedAt(),
                     ];
        }

        return $this->json($data);
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

        $metaData = $this->saleEventMetaRepository->findMetaBySaleEventId($id);

        $all = $this->productVariantSaleEventRepository->findProductVariantsBySaleEventId($id);
        $productVariants = [];
        foreach ($all as $productVariantSaleEvent) {
            $productVariants[] = $productVariantSaleEvent->getProductVariant();
        }

        return $this->render('admin/sale_event/detail.html.twig', [
            'page_title' => 'Chi tiết sự kiện sale',
            'meta_data' => $metaData,
            'productVariants' => $productVariants,
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
            'action' => $this->generateUrl('admin_sale_event_create'),
            'attr' => [
                'class' => 'form-horizontal',
            ],
            'cancel_url' => $this->generateUrl('admin_sale_event_index'),
        ]);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                try {
                    $this->em->persist($data);
                    $this->em->flush();
                    flash()->success('Tạo sự kiện sale thành công!');
                    return $this->redirectToRoute('admin_sale_event_index');
                } catch (\Exception $e) {
                    flash()->error('Tạo mới sự kiện sale thất bại! Error: ' . $e->getMessage());
                }
                return $this->redirectToRoute('admin_sale_event_create');
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
            'action' => $this->generateUrl('admin_sale_event_update', ['id' => $id]),
            'attr' => [
                'class' => 'form-horizontal',
            ],
            'cancel_url' => $this->generateUrl('admin_sale_event_index'),
        ]);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                try {
                    $this->em->flush();

                    flash()->success('Cập nhật sự kiện Sale thành công!');
                    return $this->redirectToRoute('admin_sale_event_index');
                } catch (\Exception $e) {
                    flash()->error('Cập nhật sự kiện Sale thất bại! Error: ' . $e->getMessage());
                }
                return $this->redirectToRoute('admin_sale_event_update', ['id' => $id]);
            } else {
                flash()->error('Cập nhật sự kiện Sale thất bại!');
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

        return $this->redirectToRoute('admin_sale_event_index');
    }

    /**
     * Persist Data before flushing.
     *
     * @param SaleEvent $saleEvent
     * @param $form
     * @param bool $needPersist
     * @return void
     */
    private function persistData(SaleEvent $supplier, $form, bool $needPersist = false): void
    {
        $supplier->setName($form->get('name')->getData());

        if ($needPersist === true) {
            $this->em->persist($supplier);
        }
    }

    /**
     * Persist MetaData before flushing.
     *
     * @param SupplierEntity $supplier
     * @param array $metaData
     * @param bool $needPersist
     * @return void
     */
    private function persistMetaData(SupplierEntity $supplier, array $metaData, bool $needPersist = false): void
    {
        $existingSupplierMeta = $this->supplierMetaRepository->findBy(['supplier' => $supplier->getId()]);
        $metaMap = [];

        foreach ($existingSupplierMeta as $meta) {
            $metaMap[$meta->getMetaKey()] = $meta;
        }

        foreach ($metaData as $key => $value) {
            if (isset($metaMap[$key])) {
                // Update existing meta
                $metaMap[$key]->setMetaValue([$value]);
            } else {
                // Create new meta if it doesn't exist
                $newMeta = new SupplierMetaEntity();
                $newMeta->setSupplier($supplier);
                $newMeta->setMetaKey($key);
                $newMeta->setMetaValue([$value]);

                if ($needPersist === true) {
                    $this->em->persist($newMeta);
                }
            }
        }
    }

}
