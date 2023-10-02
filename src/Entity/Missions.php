<?php

namespace App\Entity;

use App\Repository\MissionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MissionsRepository::class)]
class Missions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $objective = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\OneToMany(mappedBy: 'mission', targetEntity: Hoursworked::class)]
    private Collection $hoursworkeds;

    public function __construct()
    {
        $this->hoursworkeds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjective(): ?string
    {
        return $this->objective;
    }

    public function setObjective(string $objective): static
    {
        $this->objective = $objective;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection<int, Hoursworked>
     */
    public function getHoursworkeds(): Collection
    {
        return $this->hoursworkeds;
    }

    public function addHoursworked(Hoursworked $hoursworked): static
    {
        if (!$this->hoursworkeds->contains($hoursworked)) {
            $this->hoursworkeds->add($hoursworked);
            $hoursworked->setMission($this);
        }

        return $this;
    }

    public function removeHoursworked(Hoursworked $hoursworked): static
    {
        if ($this->hoursworkeds->removeElement($hoursworked)) {
            // set the owning side to null (unless already changed)
            if ($hoursworked->getMission() === $this) {
                $hoursworked->setMission(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->objective;
    }
}
