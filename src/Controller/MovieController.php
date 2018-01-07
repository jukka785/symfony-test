<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Movie;

class MovieController extends Controller
{
    /**
     * @Route("/lucky/number")
     */
    public function number()
    {
        $number = mt_rand(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    /**
     * @Route("/savemovie", name="savemovie")
     */
    public function saveMovie()
    {
        $em = $this->getDoctrine()->getManager();

        $movie = new Movie();
        $movie->setName('The Kiho');
        $movie->setRating(5);
        $movie->setDescription('Paras leffa');

        $em->persist($movie);

        $em->flush();

        return new Response('Saved new movie with id '.$movie->getId());
    }

    /**
     * @Route("/movies", name="movies")
     */
    public function showMovies()
    {
        $movies = $this->getDoctrine()->getRepository(Movie::class)->findAll();

        if(!$movies) {
            throw $this->createNotFoundException('No movies found :(');
        }

        $serializer = $this->get('jms_serializer');
        $response = $serializer->serialize($movies,'json');

        return new Response('moobers: '.$response);
    }

    /**
     * @Route("/movies/{id}", name="showmovie", requirements={"showmovie"="\d+"})
     */
    public function showMovie($id)
    {
        $movie = $this->getDoctrine()->getRepository(Movie::class)->findById($id);

        if(!$movie) {
            throw $this->createNotFoundException('No movies found for id '.$id.' :(');
        }

        $serializer = $this->get('jms_serializer');
        $response = $serializer->serialize($movie,'json');

        return new Response('moober: ' . $response);
    }
}
