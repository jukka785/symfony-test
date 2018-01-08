<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Name missing!")
     * @Assert\Length(
     *      min=1,
     *      max=100,
     *      minMessage="Name bust be at least {{ limit }} characters long",
     *      maxMessage="Name cannot be longer than {{ limit }} characters long"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Range(
     *      min = 1900,
     *      minMessage = "Release year must be atleast {{ limit }}"
     * )
     */
    private $year;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\Range(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Rating must be at least {{ limit }}",
     *      maxMessage = "Rating cannot be bigger than {{ limit }}"
     * )
     */
    private $rating;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(
     *      min = 1,
     *      max = 500,
     *      minMessage="Description bust be at least {{ limit }} characters long",
     *      maxMessage="Description cannot be longer than {{ limit }} characters long"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person")
     * @ORM\JoinColumn(nullable=true)
     */
    private $director;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setYear(string $year): void
    {
        $this->year = $year;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setRating(string $rating): void
    {
        $this->rating = $rating;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDirector(): Person
    {
        return $this->director;
    }

    public function setDirector(Person $director): void
    {
        $this->director = $director;
    }
}
