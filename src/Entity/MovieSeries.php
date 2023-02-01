<?php

namespace App\Entity;

use App\Repository\MovieSeriesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Internal\TentativeType;

#[ORM\Entity(repositoryClass: MovieSeriesRepository::class)]
class MovieSeries implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $synopsis = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $creat_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatAt(): ?\DateTimeImmutable
    {
        return $this->creat_at;
    }

    public function setCreatAt(\DateTimeImmutable $creat_at): self
    {
        $this->creat_at = $creat_at;

        return $this;
    }

    #[ArrayShape(['id' => "int|null", 'name' => "null|string", 'type' => "null|string", 'synopsis' => "null|string", 'create_at' => "\DateTimeImmutable|null"])]
    public function jsonSerialize(): array
    {
        return array(
          'id' => $this->getId(),
          'name' => $this->getName(),
          'type' => $this->getType(),
          'synopsis' => $this->getSynopsis(),
          'create_at' => $this->getCreatAt()
        );
    }
}
