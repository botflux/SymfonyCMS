<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use phpDocumentor\Reflection\Types\This;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminProjectController extends AbstractController
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;
    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(ProjectRepository $projectRepository, ObjectManager $manager)
    {
        $this->projectRepository = $projectRepository;
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/project", name="admin.project.index")
     */
    public function index ()
    {
        $projects = $this->projectRepository->findAll();

        return $this->render('admin/project/index.html.twig', [
            'projects' => $projects
        ]);
    }

    /**
     * @Route("/admin/project/add", name="admin.project.add", methods="GET|POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add (Request $request)
    {
        $project = new Project();
        $projectForm = $this->createForm(ProjectType::class, $project);

        $projectForm->handleRequest($request);

        if ($projectForm->isSubmitted() && $projectForm->isValid())
        {
            $project = $projectForm->getData();
            $this->manager->persist($project);
            $this->manager->flush();
            return $this->redirectToRoute('admin.project.index', [], 301);
        }

        return $this->render('admin/project/add.html.twig', [
           'form' => $projectForm->createView()
        ]);
    }

    /**
     * @Route("/admin/project/{id}", name="admin.project.edit", methods="GET|POST", requirements={"id": "\d+"})
     * @param Project $project
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit (Project $project, Request $request)
    {
        $projectForm = $this->createForm(ProjectType::class, $project);

        $projectForm->handleRequest($request);

        if ($projectForm->isSubmitted() && $projectForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('admin.project.index', [], 301);
        }

        return $this->render('admin/project/edit.html.twig', [
           'form' => $projectForm->createView()
        ]);
    }

    /**
     * @param Project $project
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/admin/project/{id}", name="admin.project.delete", methods="DELETE", requirements={"id": "\d+"})
     */
    public function delete (Project $project)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();

        return $this->redirectToRoute('admin.project.index');
    }
}