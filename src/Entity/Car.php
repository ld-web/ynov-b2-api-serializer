<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 */
class Car extends AbstractEntity
{
  // use CreatedTrait;

  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   * @Groups("car:detail")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255)
   * @Groups("car:detail")
   */
  private $name;

  /**
   * @ORM\Column(type="integer")
   * @Groups("car:detail")
   */
  private $releaseYear;

  /**
   * @ORM\Column(type="integer", nullable=true)
   * @Groups("car:detail")
   */
  private $kilometers;

  /**
   * @ORM\Column(type="boolean")
   */
  private $visible;

  /**
   * @ORM\Column(type="integer")
   * @Groups("car:detail")
   * Contrainte de validation, pour vérifier, lors d'une validation d'entité Car,
   * que le champ $transmission contient une donnée valide.
   * Pour avoir la liste des données valides, le composant de validation
   * va exécuter la méthode Transmission::getTransmissions.
   * Si la valeur passée n'existe pas dans le tableau de valeurs valides, alors la validation échoue
   * @Assert\Choice(callback={"App\Car\Transmission", "getTransmissions"})
   */
  private $transmission;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\Color", inversedBy="cars")
   * @Groups("car:detail")
   */
  private $color;

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

  public function getReleaseYear(): ?int
  {
    return $this->releaseYear;
  }

  public function setReleaseYear(int $releaseYear): self
  {
    $this->releaseYear = $releaseYear;

    return $this;
  }

  public function getKilometers(): ?int
  {
    return $this->kilometers;
  }

  public function setKilometers(?int $kilometers): self
  {
    $this->kilometers = $kilometers;

    return $this;
  }

  public function getVisible(): ?bool
  {
    return $this->visible;
  }

  public function setVisible(bool $visible): self
  {
    $this->visible = $visible;

    return $this;
  }

  public function getTransmission(): ?int
  {
    return $this->transmission;
  }

  public function setTransmission(int $transmission): self
  {
    $this->transmission = $transmission;

    return $this;
  }

  public function getColor(): ?Color
  {
    return $this->color;
  }

  public function setColor(?Color $color): self
  {
    $this->color = $color;

    return $this;
  }
}
