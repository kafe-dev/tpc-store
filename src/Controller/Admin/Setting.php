<?php
/**
 * @project tpc-store
 * @author hoepjhsha
 * @email hiepnguyen3624@gmail.com
 * @date 06/01/2025
 * @time 15:05
 */

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Contract\Crud\CrudInterface;
use App\Controller\BaseController;
use App\Entity\Setting as SettingEntity;
use App\Repository\SettingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/admin/setting', name: 'admin_setting_')]
class Setting extends BaseController implements CrudInterface
{
    /**
     * Setting Repository
     *
     * @var SettingRepository $settingRepository
     */
    private SettingRepository $settingRepository;

    /**
     * Constructor
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        parent::__construct($em, $serializer);

        $this->settingRepository = $em->getRepository(SettingEntity::class);
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/setting/index.html.twig');
    }

    /**
     * Return list of all settings.
     *
     * @return JsonResponse
     */
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $settings = $this->settingRepository->findAll();
        $data = [];
        $json = $this->serializer->serialize($settings, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getName();
            },
        ]);
        $settings = json_decode($json, true);

        if (! empty($settings)) {
            foreach ($settings as $setting) {
                $setting['actions'] = [
                    'detail' => $this->generateUrl('admin_setting_detail', ['id' => $setting['id']]),
                    'update' => '', //$this->generateUrl('', ['id' => $setting['id']]),
                    'delete' => '', //$this->generateUrl('', ['id' => $setting['id']]),
                ];
                $data[] = $setting;
            }
        }

        return new JsonResponse($data);
    }

    /**
     * Return setting detail page.
     *
     * @param int $id
     * @return Response
     */
    #[Route('/detail/{id}', name: 'detail', methods: ['GET'])]
    public function detail(int $id): Response
    {
        $setting = $this->settingRepository->find($id);

        return $this->render('admin/setting/detail.html.twig', [
            'setting' => $setting,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        // TODO: Implement create() method.
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function update(int $id, Request $request): Response
    {
        // TODO: Implement update() method.
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function delete(int $id, Request $request): Response
    {
        // TODO: Implement delete() method.
    }
}