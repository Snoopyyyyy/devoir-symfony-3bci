<?php

namespace App\Controller;

use App\Exception\Error400;
use App\Exception\Error404;
use App\Service\MovieSeriesService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MovieSeriesController extends AbstractController
{
    private readonly MovieSeriesService $movieSeriesService;
    public function __construct(MovieSeriesService $movieSeriesService)
    {
        $this->movieSeriesService = $movieSeriesService;
    }

    #[Route('/api/create', name: 'app_movie_series_create', methods: ['POST'])]
    public function index(Request $request, LoggerInterface $logger): JsonResponse
    {
        try {
            $body = json_decode($request->getContent(), true);
            return $this->json($this->movieSeriesService->create($body), 201);
        }catch (Error400 $e) {
            return $this->json($e, 400);
        }catch (Exception $e) {
            $logger->error($e->getMessage());
            return $this->json(['status' => 'error', 'message' => 'internal server error'], 500);
        }
    }

    #[Route('/api/getall', name: 'app_movie_series_list', methods: ['GET'])]
    public function list(): JsonResponse {
        return $this->json($this->movieSeriesService->getAll());
    }

    #[Route('/api/get/{id}', name: 'app_movie_series_read', methods: ['GET'])]
    public function read(int $id): JsonResponse {
        try {
            return $this->json($this->movieSeriesService->getById($id));
        } catch (Error404 $e) {
            return $this->json($e, 404);
        }
    }
}
