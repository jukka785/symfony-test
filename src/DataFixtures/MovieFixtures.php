<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $movie = new Movie();
            $movie->setName('movie '.$i);
            $movie->setYear(mt_rand(1900, 2018));
            $movie->setRating(mt_rand(1 * 10, 5 * 10) / 10);
            $movie->setDescription('description '.$i);
            $manager->persist($movie);
        }

        $manager->flush();
    }
}
