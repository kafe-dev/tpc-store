<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Supplier;
use App\Entity\SupplierMeta;
use App\Form\Type\SupplierType;
use App\Repository\SupplierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
/**
 * Class Supplier.
 *
 * This controller handles all the actions for the admin supplier.
 */
#[Route('/admin/supplier',name: 'admin_supplier_')]
final class SupplierController extends BaseController
{
    /**
     * Action index.
     *
     * @param SupplierRepository $supplierRepository
     * @return Response
     */
    #[Route(name: 'index', methods: ['GET'])]
    public function index(SupplierRepository $supplierRepository): Response
    {
        return $this->render('admin/supplier/index.html.twig', [
            'suppliers' => $supplierRepository->findAllWithMetadata(),
        ]);
    }

    /**
     * Action new.
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $supplier = new Supplier();
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($supplier);
            $entityManager->flush();
            $metaData = [
                'Address' => $form->get('address')->getData(),
                'Description' => $form->get('description')->getData(),
                'Phone' => $form->get('phone')->getData(),
                'Email' => $form->get('email')->getData(),
            ];
            foreach ($metaData as $key => $value) {
                if ($value) {
                    $supplierMeta = new SupplierMeta();
                    $supplierMeta->setSupplier($supplier);
                    $supplierMeta->setMetaKey($key);
                    $supplierMeta->setMetaValue([$value]);
                    $entityManager->persist($supplierMeta);
                }
            };
            $entityManager->flush();

            return $this->redirectToRoute('admin_supplier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/supplier/new.html.twig', [
            'supplier' => $supplier,
            'form' => $form,
        ]);
    }

    /**
     * Action show.
     *
     * @param Supplier $supplier
     * @return Response
     */
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Supplier $supplier): Response
    {
        return $this->render('admin/supplier/show.html.twig', [
            'supplier' => $supplier,
        ]);
    }

    /**
     * Action edit.
     *
     * @param Request $request
     * @param Supplier $supplier
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Supplier $supplier, EntityManagerInterface $entityManager): Response
    {
        $supplierMetas = $supplier->getSupplierMetas()->getValues();
        $metaData = [];
        foreach ($supplierMetas as $meta) {
            $metaData[$meta->getMetaKey()] = implode(', ', $meta->getMetaValue());
        }
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $originalName = $supplier->getName();
            $newName = $form->get('name')->getData();
            if ($originalName !== $newName) {
                $supplier->setName($newName);
            }
            foreach ($metaData as $key => $value) {
                $newValue = $form->get(strtolower($key))->getData();
                if ($newValue !== $value) {
                    $supplierMeta = $supplier->getSupplierMetas()->filter(function($meta) use ($key) {
                        return $meta->getMetaKey() === $key;
                    })->first();
                    if ($supplierMeta) {
                        $supplierMeta->setMetaValue([$newValue]);
                    }
                }
            }
            $entityManager->flush();
            return $this->redirectToRoute('admin_supplier_index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('admin/supplier/edit.html.twig', [
            'supplier' => $supplier,
            'form' => $form,
            'metaData' => $metaData,
        ]);
    }
    /**
     * Action delete.
     *
     * @param Request $request
     * @param Supplier $supplier
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Supplier $supplier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$supplier->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($supplier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_supplier_index', [], Response::HTTP_SEE_OTHER);
    }
}
