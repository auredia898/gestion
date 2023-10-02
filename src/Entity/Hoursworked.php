<?php

namespace App\Entity;

use App\Repository\HoursworkedRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoursworkedRepository::class)]
class Hoursworked
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $period = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2)]
    private ?string $numberHours = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $workDays = null;

    #[ORM\ManyToOne(inversedBy: 'hoursworkeds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employees $employee = null;

    #[ORM\ManyToOne(inversedBy: 'hoursworkeds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Missions $mission = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeriod(): ?string
    {
        return $this->period;
    }

    public function setPeriod(string $period): static
    {
        $this->period = $period;

        return $this;
    }

    public function getNumberHours(): ?string
    {
        return $this->numberHours;
    }

    public function setNumberHours(string $numberHours): static
    {
        $this->numberHours = $numberHours;

        return $this;
    }

    public function getWorkDays(): ?\DateTimeInterface
    {
        return $this->workDays;
    }

    public function setWorkDays(\DateTimeInterface $workDays): static
    {
        $this->workDays = $workDays;

        return $this;
    }

    public function getEmployee(): ?Employees
    {
        return $this->employee;
    }

    public function setEmployee(?Employees $employee): static
    {
        $this->employee = $employee;

        return $this;
    }

    public function getMission(): ?Missions
    {
        return $this->mission;
    }

    public function setMission(?Missions $mission): static
    {
        $this->mission = $mission;

        return $this;
    }
}
