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
     * @Route("admin/tag/{id}", name="admin.tag.edit")
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
            return $this->redirectToRoute('admin.tag.index', [], 301);
        }

        return $this->render('admin/tag/edit.html.twig', [
            'tagForm' => $tagForm->createView()
        ]);
    }
}