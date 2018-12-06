<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var CategoryRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $manager, CategoryRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/category", name="admin.category.index")
     */
    public function index ()
    {
        $categories = $this->repository->findAll();

        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/category/add", name="admin.category.add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add (Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($category);
            $this->manager->flush();

            return $this->redirectToRoute('admin.category.index', [], 301);
        }

        return $this->render('admin/category/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/category/{id}", name="admin.category.edit", methods="GET|POST", requirements={"id": "\d+"})
     * @param Category $category
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit (Category $category, Request $request)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();

            return $this->redirectToRoute('admin.category.index', [], 301);
        }

        return $this->render('admin/category/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/category/{id}", name="admin.category.delete", methods="DELETE", requirements={"id": "\d+"})
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete (Category $category)
    {
        $this->manager->remove($category);
        $this->manager->flush();

        return $this->redirectToRoute('admin.category.index', [], 301);
    }
}