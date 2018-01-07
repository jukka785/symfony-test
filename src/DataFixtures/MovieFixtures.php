<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $person = new Person();
        $person->setName('Stanley Kubrick');
        $person2 = new Person();
        $person2->setName('Seppo Taalasmaa');
        $manager->persist($person);
        $manager->persist($person2);

        for ($i = 0; $i < 10; $i++) {
            $movie = new Movie();
            $movie->setName('movie '.$i);
            $movie->setYear(mt_rand(1900, 2018));
            $movie->setRating(mt_rand(1 * 10, 5 * 10) / 10);
            $movie->setDescription('description '.$i);
            $i > 4 ? $movie->setDirector($person) : $movie->setDirector($person2);
            $manager->persist($movie);
        }

        $manager->flush();
    }
}
