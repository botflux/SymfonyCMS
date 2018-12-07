<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminTagController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $manager;
    /**
     * @var TagRepository
     */
    private $tagRepository;

    public function __construct(ObjectManager $manager, TagRepository $tagRepository)
    {
        $this->manager = $manager;
        $this->tagRepository = $tagRepository;
    }

    /**
     * @Route("/admin/tag", name="admin.tag.index")
     */
    public function index ()
    {
        $tags = $this->tagRepository->findAll();

        return $this->render('admin/tag/index.html.twig', [
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/admin/tag/add", name="admin.tag.add", methods="GET|POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function add (Request $request)
    {
        $tag = new Tag();

        $tagForm = $this->createForm(TagType::class, $tag);
        $tagForm->handleRequest($request);

        if ($tagForm->isSubmitted() && $tagForm->isValid()) {
            $tag = $tagForm->getData();

            $this->manager->persist($tag);
            $this->manager->flush();

            $this->addFlash('success', 'Your tag has been created');

            return $this->redirectToRoute('admin.tag.index', [], 301);
        }

        return $this->render('admin/tag/add.html.twig', [
            'tagForm' => $tagForm->createView()
        ]);
    }

    /**
     * @Route("admin/tag/{id}", name="admin.tag.edit", methods="GET|POST", requirements={"id": "\d+"})
     * @param Tag $tag
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit (Tag $tag, Request $request)
    {
        $tagForm = $this->createForm(TagType::class, $tag);

        $tagForm->handleRequest($request);

        if ($tagForm->isSubmitted() && $tagForm->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', 'Your tag has been modified');
            return $this->redirectToRoute('admin.tag.index', [], 301);
        }

        return $this->render('admin/tag/edit.html.twig', [
            'tagForm' => $tagForm->createView()
        ]);
    }

    /**
     * @Route("admin/tag/{id}", methods="DELETE", name="admin.tag.delete", methods="DELETE", requirements={"id": "\d+"})
     * @param Tag $tag
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete (Tag $tag)
    {
        $this->manager->remove($tag);
        $this->manager->flush();
        $this->addFlash('primary', 'Your tag has been deleted');

        return $this->redirectToRoute('admin.tag.index');
    }

}