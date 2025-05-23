<?php

namespace App\Entity;

use App\Repository\SteamAppRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SteamAppRepository::class)]
class SteamApp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $appId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAppId(): ?int
    {
        return $this->appId;
    }

    public function setAppId(int $appId): static
    {
        $this->appId = $appId;

        return $this;
    }
}
