<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Contract\Crud\CrudInterface;
use App\Controller\BaseController;
use App\Entity\Product as ProductEntity;
use App\Entity\Supplier as SupplierEntity;
use App\Entity\SupplierMeta as SupplierMetaEntity;
use App\Form\Type\SupplierType;
use App\Repository\ProductRepository;
use App\Repository\SupplierMetaRepository;
use App\Repository\SupplierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

use function PHPUnit\Framework\isEmpty;

/**
 * Class Supplier.
 *
 * This controller handles all the actions for the admin supplier.
 */
#[Route('/admin/supplier', name: 'admin_supplier_')]
class Supplier extends BaseController implements CrudInterface
{
    /**
     * Supplier Repository
     *
     * @var SupplierRepository $supplierRepository
     */
    private SupplierRepository $supplierRepository;
    /**
     * Product Repository
     *
     * @var ProductRepository $productRepository
     */
    private ProductRepository $productRepository;
    /**
     * Supplier Meta Repository
     *
     * @var SupplierMetaRepository $supplierMetaRepository
     */
    private SupplierMetaRepository $supplierMetaRepository;
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer);

        $this->supplierRepository = $em->getRepository(SupplierEntity::class);
        $this->productRepository = $em->getRepository(ProductEntity::class);
        $this->supplierMetaRepository = $em->getRepository(SupplierMetaEntity::class);
        $this->serializer = $serializer;
    }

    /**
     * Action index.
     *
     * @param
     * @return Response
     */
    #[Route("/", name: "index", methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/supplier/index.html.twig');
    }

    /**
     * Action list return data
     *
     * @param
     * @return JsonResponse
     */

    #[Route('/list', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $suppliers = $this->supplierRepository->findAllWithMetadata();
        $data = [];
        $json = $this->serializer->serialize($suppliers, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getName();
            },
        ]);
        $suppliers = json_decode($json, true);
        
        if (! empty($suppliers)) {
            foreach ($suppliers as $supplier) {
                $supplier['actions'] = [
                    'detail' => $this->generateUrl('admin_supplier_detail', ['id' => $supplier['id']]),
                    'update' => $this->generateUrl('admin_supplier_update', ['id' => $supplier['id']]),
                    'delete' => $this->generateUrl('admin_supplier_delete', ['id' => $supplier['id']]),
                ];
                $data[] = $supplier;
            }
        }
        
        return new JsonResponse($data);

    }

    /**
     * Action create new supplier.
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $supplier = new SupplierEntity();
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (! $this->supplierRepository->isNameUnique($form->get('name')->getData())) {
                return $this->redirectToRoute('admin_supplier_create');
            }
            
            $this->persistData($supplier, $form, true);
            $this->em->flush();
            
            $metaData = [
                'Address' => $form->get('address')->getData(),
                'Description' => $form->get('description')->getData(),
                'Phone' => $form->get('phone')->getData(),
                'Email' => $form->get('email')->getData(),
            ];
          
            $this->persistMetaData($supplier, $metaData, true);
            $this->em->flush();
            
            return $this->redirectToRoute('admin_supplier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/supplier/create.html.twig', [
            'supplier' => $supplier,
            'form' => $form,
        ]);
    }

    /**
     * Action detail show supplier detail.
     *
     * @param int $id
     * @return Response
     */
    #[Route('/detail/{id}', name: 'detail', methods: ['GET'])]
    public function detail(int $id): Response
    {
        $supplier = $this->supplierRepository->find($id);

        $products = $this->productRepository->findBy(['supplier' => $id]);

        return $this->render('admin/supplier/detail.html.twig', [
            'supplier' => $supplier,
            'products' => $products,
        ]);
    }

    /**
     * Action edit.
     *
     * @param int $id
     * @param Request $request
     * @return Response
     */
    #[Route('/update/{id}', name: 'update', methods: ['GET', 'POST'])]
    public function update(int $id, Request $request): Response
    {
        $supplier = $this->supplierRepository->findByIdWithMetadata($id);

        $supplierMetas = $supplier->getSupplierMetas();
        $metaData = [];

        foreach ($supplierMetas as $meta) {
            $metaData[$meta->getMetaKey()] = implode(', ', $meta->getMetaValue());
        }
        
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistData($supplier, $form);
            $updatedMetaData = [];
            
            foreach ($metaData as $key => $value) {
                $newValue = $form->get(strtolower($key))->getData();
                
                if ($newValue !== $value) {
                    $updatedMetaData[$key] = $newValue;
                }
            }

            $this->persistMetaData($supplier, $updatedMetaData);
            $this->em->flush();

            return $this->redirectToRoute('admin_supplier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/supplier/update.html.twig', [
            'supplier' => $supplier,
            'form' => $form,
            'metaData' => $metaData,
        ]);
    }

    /**
     * Action delete supplier.
     *
     * @param int $id
     * @param Request $request
     * @return Response
     */
    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(int $id, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->getPayload()->getString('_token'))) {
            $supplier = $this->supplierRepository->find($id);
            $this->em->remove($supplier);
            $this->em->flush();
        }

        return new JsonResponse(['success' => true], Response::HTTP_OK);
    }

    /**
     * Persist Data before flushing.
     *
     * @param SupplierEntity $supplier
     * @param $form
     * @param bool $needPersist
     * @return void
     */
    private function persistData(SupplierEntity $supplier, $form, bool $needPersist = false): void
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
