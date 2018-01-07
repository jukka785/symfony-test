<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Movie;

class MovieController extends Controller
{
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
     * @Route("/movies/{id}", name="showmovie", requirements={"id"="\d+"})
     */
    public function showMovie($id)
    {
        $movie = $this->getDoctrine()->getRepository(Movie::class)->findOneById($id);

        if(!$movie) {
            throw $this->createNotFoundException('No movies found for id '.$id.' :(');
        }

        $serializer = $this->get('jms_serializer');
        $response = $serializer->serialize($movie,'json');

        return new Response('moober: ' . $response);
    }

    /**
     * @Route("/movies/edit/{id}", name="updatemovie", requirements={"id"="\d+"})
     */
    public function updateMovie($id)
    {
        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository(Movie::class)->findOneById($id);

        if (!$movie) {
            throw $this->createNotFoundException('No movie found for id '.$id.' :(');
        }

        $movie->setName('uus leffa');
        $em->flush();

        return $this->redirectToRoute('showmovie', array('id' => $movie->getId()));
    }

    /**
     * @Route("/movies/delete/{id}", name="deletemovie", requirements={"id"="\d+"})
     */
    public function deleteMovie($id)
    {
        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository(Movie::class)->findOneById($id);

        if (!$movie) {
            throw $this->createNotFoundException('No movie found for id '.$id.' :(');
        }

        $em->remove($movie);
        $em->flush();

        return $this->redirectToRoute('movies');
    }

    /**
     * @Route("/movies/find/{year}", name="findmovies", requirements={"year"="\d+"})
     */
    public function findMovies($year)
    {
        $movies = $this->getDoctrine()->getRepository(Movie::class)->findAllAfterYear($year);

        if (!$movies) {
            throw $this->createNotFoundException('No movies :(');
        }

        $serializer = $this->get('jms_serializer');
        $response = $serializer->serialize($movies, 'json');

        return new Response('moobers found: '.count($movies));
    }
}
