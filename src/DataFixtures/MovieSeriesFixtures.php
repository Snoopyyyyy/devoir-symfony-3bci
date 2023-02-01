<?php

namespace App\DataFixtures;

use App\Entity\MovieSeries;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieSeriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $movie = new MovieSeries();
            $movie->setName("Movie N°".$i)
                ->setType((bool)rand(0,1) ? "MOVIE" : "SERIES")
                ->setSynopsis("le synopsys des fixtures !")
                ->setCreatAt(new DateTimeImmutable('-'.$i.'days'));

            $manager->persist($movie);
        }
        $manager->flush();
    }
}
