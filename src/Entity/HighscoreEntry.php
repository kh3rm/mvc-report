<?php

namespace App\Entity;

use App\Repository\HighscoreEntryRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use DateTimeZone;

#[ORM\Entity(repositoryClass: HighscoreEntryRepository::class)]
class HighscoreEntry
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private ?int $id; // @phpstan-ignore-line

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $score = null;

    #[ORM\Column(type: "datetime")]
    private ?\DateTime $createdAt = null;

    public function __construct()
    {
        $timezone = new DateTimeZone('CEST');
        $this->createdAt = new DateTime('now', $timezone);
    }

    /**
     * Gets the highscore entry's id.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the player's name.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets the player's name.
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the player's score.
     */
    public function getScore(): ?int
    {
        return $this->score;
    }

    /**
     * Sets the player's score.
     */
    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Gets the creation timestamp.
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }
}
