<?php

namespace App\Controller\Admin;

use App\Entity\LearningSubject;
use App\Form\LearningSubjectType;
use App\Repository\LearningSubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminLearningSubjectController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var LearningSubjectRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $manager, LearningSubjectRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/learning-subject", name="admin.learning-subject.index")
     */
    public function index ()
    {
        $learningSubjects = $this->repository->findAll();

        return $this->render('admin/learning-subject/index.html.twig', [
           'learningSubjects' => $learningSubjects
        ]);
    }

    /**
     * @Route("/admin/learning-subject/{id}", name="admin.learning-subject.edit", methods="GET|POST", requirements={"id": "\d+"})
     * @param LearningSubject $learningSubject
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit (LearningSubject $learningSubject, Request $request)
    {
        $form = $this->createForm(LearningSubjectType::class, $learningSubject);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            return $this->redirectToRoute('admin.learning-subject.index');
        }

        return $this->render('admin/learning-subject/edit.html.twig', [
           'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/learning-subject/{id}", name="admin.learning-subject.delete", methods="DELETE", requirements={"id": "\d+"})
     * @param LearningSubject $learningSubject
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete (LearningSubject $learningSubject)
    {
        $this->manager->remove($learningSubject);
        $this->manager->flush();

        return $this->redirectToRoute('admin.learning-subject.index', [], 301);
    }

    /**
     * @Route("/admin/learning-subject/add", name="admin.learning-subject.add", methods="GET|POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add (Request $request)
    {
        $learningSubject = new LearningSubject();
        $form = $this->createForm(LearningSubjectType::class, $learningSubject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($learningSubject);
            $this->manager->flush();

            return $this->redirectToRoute('admin.learning-subject.index');
        }

        return $this->render('admin/learning-subject/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}