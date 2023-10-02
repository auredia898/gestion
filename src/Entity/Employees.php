<?php

namespace App\Entity;

use App\Repository\EmployeesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeesRepository::class)]
class Employees
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Positions $position = null;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: Hoursworked::class)]
    private Collection $hoursworkeds;

    public function __construct()
    {
        $this->hoursworkeds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPosition(): ?Positions
    {
        return $this->position;
    }

    public function setPosition(?Positions $position): static
    {
        $this->position = $position;

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
            $hoursworked->setEmployee($this);
        }

        return $this;
    }

    public function removeHoursworked(Hoursworked $hoursworked): static
    {
        if ($this->hoursworkeds->removeElement($hoursworked)) {
            // set the owning side to null (unless already changed)
            if ($hoursworked->getEmployee() === $this) {
                $hoursworked->setEmployee(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
