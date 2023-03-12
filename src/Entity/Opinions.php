<?php

namespace App\Entity;

use App\Repository\OpinionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpinionsRepository::class)]
class Opinions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $coment = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $city = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComent(): ?string
    {
        return $this->coment;
    }

    public function setComent(string $coment): self
    {
        $this->coment = $coment;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }
}
