<?php

namespace App\Service;

use App\Entity\MovieSeries;
use App\Exception\Error400;
use App\Exception\Error404;
use App\Repository\MovieSeriesRepository;
use DateTimeImmutable;

class MovieSeriesService
{
    private readonly MovieSeriesRepository $movieSeriesRepository;
    public function __construct(MovieSeriesRepository $movieSeriesRepository)
    {
        $this->movieSeriesRepository = $movieSeriesRepository;
    }

    public function getAll(): array {
        return $this->movieSeriesRepository->findAll();
    }

    /**
     * @throws Error404
     */
    public function getById(int $id): MovieSeries {
        $movieSeries = $this->movieSeriesRepository->find($id);
        if($movieSeries != null) {
            return $movieSeries;
        } else throw new Error404("No series or film found with that id");
    }

    /**
     * @throws Error400
     */
    public function create(array $raw): MovieSeries {
        $movie = new MovieSeries();
        $movie->setName($this->getData($raw, 'name'))
            ->setType($this->getData($raw, 'type'))
            ->setSynopsis($this->getData($raw, 'synopsis'))
            ->setCreatAt(new DateTimeImmutable('now'));

        $this->movieSeriesRepository->save($movie, true);
        return $movie;
    }

    /**
     * @throws Error400
     */
    private function getData(array $body, string $key): string {
        if(array_key_exists($key, $body) && $body[$key] != null) return $body[$key];
        throw new Error400($key . " is required");
    }
}