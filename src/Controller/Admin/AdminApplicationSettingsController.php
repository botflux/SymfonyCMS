<?php

namespace App\Controller\Admin;

use App\Form\ApplicationSettingsType;
use App\Repository\ApplicationSettingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminApplicationSettingsController extends AbstractController
{
    /**
     * @var ApplicationSettingsRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * AdminApplicationSettingsController constructor.
     * @param ApplicationSettingsRepository $repository
     * @param EntityManagerInterface $manager
     */
    public function __construct(ApplicationSettingsRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/application-settings", name="admin.application-settings.index", methods="GET|POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index (Request $request)
    {
        $settings = $this->repository->findSettings();
        $form = $this->createForm(ApplicationSettingsType::class, $settings);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Application settings has been edited.');
            $this->manager->flush();
        }

        return $this->render('admin/application-settings/index.html.twig', [
            'settings' => $settings,
            'form' => $form->createView()
        ]);
    }
}