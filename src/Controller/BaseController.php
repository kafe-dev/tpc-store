<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class BaseController.
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 *
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends AbstractController
{

    /**
     * @var EntityManagerInterface $em EntityManagerInterface instance
     */
    protected EntityManagerInterface $em;

    /**
     * Constructor.
     *
     * @param  EntityManagerInterface  $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

}
