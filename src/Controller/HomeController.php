<?php

namespace App\Controller;

use App\Repository\LearningSubjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home.index")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @param LearningSubjectRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/about", name="home.about")
     */
    public function about(LearningSubjectRepository $repository)
    {
        $learningSubjects = $repository->findMostImportant ();

        return $this->render('home/about.html.twig', [
            'learningSubjects' => $learningSubjects
        ]);
    }
}
