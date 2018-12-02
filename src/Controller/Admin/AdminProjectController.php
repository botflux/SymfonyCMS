<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminProjectController extends AbstractController
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
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
     * @Route("/admin/project/{id}", name="admin.project.edit", methods="GET|POST")
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
     * @param Request $request
     * @Route("/admin/project/{id}", name="admin.project.delete", methods="DELETE")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete (Project $project, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();

        return $this->redirectToRoute('admin.project.index');
    }
}