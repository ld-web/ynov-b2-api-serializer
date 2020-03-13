<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ColorRepository")
 */
class Color extends AbstractEntity
{
  // use CreatedTrait;

  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255)
   * @Groups("car:detail")
   */
  private $name;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   * @Groups("car:detail")
   */
  private $hexCode;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Car", mappedBy="color")
   */
  private $cars;

  public function __construct()
  {
    $this->cars = new ArrayCollection();
  }

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

  public function getHexCode(): ?string
  {
    return $this->hexCode;
  }

  public function setHexCode(?string $hexCode): self
  {
    $this->hexCode = $hexCode;

    return $this;
  }

  /**
   * @return Collection|Car[]
   */
  public function getCars(): Collection
  {
    return $this->cars;
  }

  public function addCar(Car $car): self
  {
    if (!$this->cars->contains($car)) {
      $this->cars[] = $car;
      $car->setColor($this);
    }

    return $this;
  }

  public function removeCar(Car $car): self
  {
    if ($this->cars->contains($car)) {
      $this->cars->removeElement($car);
      // set the owning side to null (unless already changed)
      if ($car->getColor() === $this) {
        $car->setColor(null);
      }
    }

    return $this;
  }
}
