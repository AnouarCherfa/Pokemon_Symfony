<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\PokemonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
#[ApiResource(
    validationContext: ['groups' => [Pokemon::class, 'put:validator']],
    paginationItemsPerPage: 12,
    paginationMaximumItemsPerPage: 20,
    paginationClientItemsPerPage: true,
)]
#[GetCollection()]
#[Delete()]
#[Get(
    normalizationContext: ['groups' => ['get']]
)]
#[Put(

    denormalizationContext: ['groups' => ['put']]
)]
#[Post()]

#[ORM\HasLifecycleCallbacks]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]
class Pokemon
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get', 'put'])]
    #[Assert\Length(min: 3, max: 12, groups: ['put:validator'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['get', 'put'])]
    private ?int $hp = null;

    #[ORM\Column]
    #[Groups(['get', 'put'])]
    private ?int $cp = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get', 'put'])]
    private ?string $picture = null;

    #[ORM\Column]
    #[Groups(['get', 'put'])]
    private array $types = [];

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['get', 'put'])]
    private ?\DateTimeInterface $createdAt = null;

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

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setHp(int $hp): self
    {
        $this->hp = $hp;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function setTypes(array $types): self
    {
        $this->types = $types;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    #[ORM\PrePersist]
    #[Groups(['get'])]
    public function setCreatedAtValue(): void {
        $this->createdAt = new \DateTimeImmutable("now");
    }

}
