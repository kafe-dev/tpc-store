<?php
/**
 * @project tpc-store
 * @author NTDzVEKNY
 * @email ntdgdeptrai@gmail.com
 * @date 1/6/2025
 * @time 2:12 PM
 */

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Contract\Crud\CrudInterface;
use App\Controller\BaseController;
use App\Entity\UserAddress as UserAddressEntity;
use App\Repository\UserAddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route("/admin/address", name: "admin_address_")]
class Address extends BaseController implements CrudInterface
{
    /**
     *
     */
    private UserAddressRepository $userAddressRepository;
    /**
     * Override the default
     *
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer);

        $this->userAddressRepository = $this->em->getRepository(UserAddressEntity::class);
    }
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
     * Action list.
     *
     * This action for getting all user address.
     *
     * @return JsonResponse
     */
    #[Route("/list", name: "list", methods: ['GET', 'POST'])]
    public function list(): JsonResponse
    {
        $userAddresses = $this->userAddressRepository->findAll();
        $data = [];
        $userAddresses = $this->getJsonListAddress($userAddresses);

        if (!empty($userAddresses)) {
            foreach ($userAddresses as $userAddress) {
                $userAddressEntity = $this->userAddressRepository->find($userAddress['id']);
                $userAddress['actions'] = [
                    'detail' => $this->generateUrl('admin_address_detail', ['id' => $userAddressEntity->getId()]),
                    'update' => $this->generateUrl('admin_address_update', ['id' => $userAddressEntity->getId()]),
                    'delete' => $this->generateUrl('admin_address_delete', ['id' => $userAddressEntity->getId()]),
                ];
                $data[] = $userAddress;
            }
        }
        return new JsonResponse($data);
    }

    /**
     * @inheritDoc
     */
    #[Route("/detail", name: "detail", methods: ["GET", "POST"])]
    public function detail(int $id): Response
    {
        // TODO: Implement detail() method.
    }

    /**
     * @inheritDoc
     */
    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        // TODO: Implement create() method.
    }

    /**
     * @inheritDoc
     */
    #[Route("/update", name: "update", methods: ['GET', 'POST'])]
    public function update(int $id, Request $request): Response
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    #[Route('/delete', name: 'delete', methods: ['POST'])]
    public function delete(int $id, Request $request): Response
    {
        // TODO: Implement delete() method.
    }

    private function getJsonListAddress($listAddress): array
    {
        $json = $this->serializer->serialize($listAddress, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
            'attributes' => [
                'id', 'address', 'postalCode', 'type','commune',
                'user' => ['id', 'username','email'],
            ],
            'ignored_attributes' => ['communes', 'districts', 'userAddresses'],
        ]);
        return json_decode($json, true);
    }
}