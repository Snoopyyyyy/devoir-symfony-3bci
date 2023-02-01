<?php

namespace App\Controller;

use App\Entity\MovieSeries;
use App\Exception\Error400;
use App\Form\MovieSeriesRegisterType;
use App\Service\MovieSeriesService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

class HomeController extends AbstractController
{
    private readonly MovieSeriesService $movieSeriesService;
    public function __construct(MovieSeriesService $movieSeriesService)
    {
        $this->movieSeriesService = $movieSeriesService;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'movies_series' => $this->movieSeriesService->getAll()
        ]);
    }

    #[Route('/create', name: 'app_home_create')]
    public function create(Request $request): Response
    {
        $movie = new MovieSeries();
        $form = $this->createFormBuilder($movie)
            ->add('name', TextType::class)
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'select a type' => null,
                    'MOVIE' => "Movie",
                    'SERIES' => "Series",
                ],
            ])
            ->add('synopsis', TextareaType::class)
            ->add('create', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            try {
                $this->movieSeriesService->create($movie->jsonSerialize());
                return $this->redirectToRoute('app_home');
            } catch (Error400 $e) {
                return $this->render('home/create.html.twig', [
                    'form' => $form->createView(),
                    'errors' => $e->getMessage()
                ]);
            }
        }
        return $this->render('home/create.html.twig', [
            'form' => $form->createView(),
            'errors' => ""
        ]);
    }
}
