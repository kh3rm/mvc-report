<?php

namespace App\Entity;

use App\Repository\ProjectBookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectBookRepository::class)]
class ProjectBook
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private ?int $id; // @phpstan-ignore-line

    #[ORM\Column(length: 55, unique: true)]
    private ?string $isbn = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgsource = null;

    /**
     * Gets the book's id.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the book's title.
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Sets the book's title.
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets the book's author.
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * Sets the book's author.
     */
    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Gets the book's ISBN number.
     */
    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    /**
     * Sets the book's ISBN number.
     */
    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Gets the book's imgsource.
     */
    public function getImgsource(): ?string
    {
        return $this->imgsource;
    }

    /**
     * Sets the book's imgsource.
     */
    public function setImgsource(?string $imgsource): static
    {
        $this->imgsource = $imgsource;

        return $this;
    }
}
